<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Services\BookService;
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\BookFilterRequest;
use App\Http\Requests\LoadFromRequest;
use App\Jobs\LoadBooks;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService=$bookService;
        $this->authorizeResource(Book::class);
    }
    /**
     * Add filter to resource list for policy action
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'viewOnlyApproved',
            'viewNotApproved' => 'viewAny',
            'show' => 'view',
            'create'=>'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'approve' => 'approve',
            'loadfrom' => 'approve'
        ];
    }
    /**
     * Add filter to actions without model dependency for policy action
     *
     * @return array
     */
    protected function resourceMethodsWithoutModels(): array
    {
        return ['viewNotApproved', 'index', 'create', 'store', 'approve', 'loadfrom'];
    }

    /**
     * Display a listing of the resource.
     *
     * @param BookFilterRequest $request
     * @return Response
     */
    public function index(BookFilterRequest $request): Response
    {
        $booksArray = $this->bookService->filter(new FilterDataTransferObject(
            $request->title,
            $request->publisher_id,
            $request->year,
            $request->isbn,
            $request->category_id,
            $request->author_id,
            $request->tag_id,
            ($request->user()->can('view-not-approved-'.Book::class)) ?
                (($request->approved!=null) ?
                    array_map(function($value) { return (int)$value; }, $request->approved) :
                    null
                ) :
                [1,2],
            $request->sortBy
        ));
        return response()->view('book.filter', [
            'book_class'=>Book::class,
            'user'=>$request->user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'pageTitle' => __('Библиотека'),
            'books'=>$booksArray,
            'request'=>$request
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookStoreRequest $request
     * @return RedirectResponse
     */
    public function store(?BookStoreRequest $request)
    {
        $bookDTO = new BookDataTransferObject(
            $request->title,
            $request->publisher_id,
            $request->year,
            $request->isbn,
            $request->category_id,
            $request->link,
            $request->description,
            $request->author_id,
            $request->tag_id,
            'manualy'
        );
        $book = $this->bookService->new($bookDTO, Auth::id());
        return ($book!=null) ?
            response()->redirectToRoute('book.show',['book'=>$book->id]) :
            redirect()->back()->with('error','Проверьте введённые данные');
    }

    /**
     * Show form for a new record
     * 
     * @return Response
     */
    public function create()
    {
        return response()->view('book.create', [
            'pageTitle' => __('Новая книга'),
            'book_class'=>Book::class,
            'user'=>Auth::user()
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return Response
     */
    public function show(Book $book)
    {
        return response()->view('book.show',[
            'book'=>$book,
            'book_class'=>Book::class,
            'user'=>Auth::user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'pageTitle' => __($book->title)
            ]
        );
    }
    /**
     * Show form for a new record
     * 
     * @return Response
     */
    public function edit(Book $book)
    {
        return response()->view('book.edit', [
            'book' => $book,
            'pageTitle' => __($book->title)
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Book $book
     * @param BookStoreRequest $request
     * @return Response
     */
    public function update(Book $book, BookStoreRequest $request)
    {
        $bookDTO = new BookDataTransferObject(
            $request->title,
            $request->publisher_id,
            $request->year,
            $request->isbn,
            $request->category_id,
            $request->link,
            $request->description,
            $request->author_id,
            $request->tag_id,
            null
        );
        $bookUpdate = $this->bookService->update($bookDTO, $book->id);
        return ($bookUpdate)?
            response()->redirectToRoute('book.show', ['book' => $bookUpdate->id])->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        return ($this->bookService->delete($book->id)) ?
            response()->redirectToRoute('book.index')->with('success', 'Книга успешно удалена') :
            response()->redirectToRoute('book.index')->with('error', 'Не удалось удалить книгу');
    }

    /**
     * Approve or deapprove author
     *
     * @param ApproveRequest $request
     * @return RedirectResponse
     */
    public function approve(ApproveRequest $request)
    {
        return ($this->bookService->approve($request->approved, $request->id)) ?
            redirect()->back()->with('success', 'Книга опубликована') :
            redirect()->back()->with('error', 'Книга не опубликована');
    }
    /**
     * Load from yandex api
     * 
     * @param 
     * @return RedirectResponse
     */
    public function loadfrom(LoadFromRequest $request){
        return (LoadBooks::dispatch($this->bookService,$request->path, $request->user()->id)) ?
            redirect()->back()->with('success', 'Книги добавлены') :
            redirect()->back()->with('error', 'Что-то пошло не так');
    }
}
