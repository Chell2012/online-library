<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Services\BookService;
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\BookFilterRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
            'index' => 'viewAny',
            'show' => 'view',
            'store' => 'create',
            'create'=> 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'approve' => 'approve'
        ];
    }
    /**
     * Add filter to actions without model dependency for policy action
     *
     * @return array
     */
    protected function resourceMethodsWithoutModels(): array
    {
        return ['index', 'store', 'approve', 'create'];
    }

    /**
     * Display a listing of the resource.
     *
     * @param BookFilterRequest $request
     * @return View
     */
    public function index(BookFilterRequest $request): View
    {
        $booksArray = $this->bookService->filter(new FilterDataTransferObject(
            $request->title,
            $request->publisher_id,
            $request->year,
            $request->isbn,
            $request->category_id,
            $request->author_id,
            $request->tag_id,
            $request->isApproved,
            $request->forApproveOnly,
            $request->sortBy
        ));
        return view('book.filter', [
            'pageTitle' => __('Библиотека'),
            'books'=>$booksArray
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookStoreRequest $request
     * @return RedirectResponse|View
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
                $request->tag_id
                );
        $book = $this->bookService->new($bookDTO);
        if ($book){
            return redirect()->route('book.show',['id'=>$book->id]);
        }
    }

    /**
     * @return Response
     */
    public function create()
    {
        return response()->view('book.create', [
            'pageTitle' => __('Новая книга')
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
        return response()->view(
            'book.show',
            ['book'=>$this->bookService->getWithRelations($book->id)]
        );
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

        $bookArray = $this->bookService->update(new BookDataTransferObject(
                $request->title,
                $request->publisher_id,
                $request->year,
                $request->isbn,
                $request->category_id,
                $request->link,
                $request->description,
                $request->author_id,
                $request->tag_id
                ), $book->id);
        return response()->json($bookArray);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        if($this->bookService->delete($book->id)){
            return redirect()->route('book.index')->with('success', 'Книга успешно удалена');
        }
        return redirect()->route('book.index')->with('error', 'Не удалось удалить книгу');
    }

    /**
     * Approve or deapprove author
     *
     * @param ApproveRequest $request
     * @return RedirectResponse
     */
    public function approve(ApproveRequest $request)
    {
        if($this->bookService->approve($request->approved, $request->id)){
            return redirect()->back()->with('success', 'Книга опубликована');
        }
        return redirect()->back()->with('error', 'Книга не опубликована');
    }
}
