<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Services\BookService;
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use App\Http\Requests\BookFilterRequest;
use App\Models\Book;

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
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'filter' => 'filter',
        ];
    }    
    /**
     * Add filter to actions without model dependency for policy action
     * 
     * @return array 
     */
    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'create', 'store', 'filter'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->bookService->list());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
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
        $bookArray = $this->bookService->new($bookDTO);
        return response()->json($bookArray);
    }
    /**
     * Display the specified resource.
     * 
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return response()->json($this->bookService->getWithRelations($book->id));
    }
    /**
     * Update the specified resource in storage.
     * 
     * @param Book $book
     * @param BookStoreRequest $request
     * @return \Illuminate\Http\Response
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
     * Return filtered list of books
     * 
     * @param BookFilterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function filter(BookFilterRequest $request){
        $bookArray = $this->bookService->filter(new FilterDataTransferObject(
            $request->title,
            $request->publisher_id,
            $request->year,
            $request->isbn,
            $request->category_id,
            $request->author_id,
            $request->tag_id
            ));
    return response()->json($bookArray);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        return response()->json($this->bookService->delete($book->id));
    }
}
