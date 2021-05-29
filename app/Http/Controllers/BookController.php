<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Services\BookService;

class BookController extends Controller
{
    private $bookService;
    public function __construct(BookService $bookService) {
        $this->bookService=$bookService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->bookService->bookList());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $bookArray = $this->bookService->setBook($request);
        return response()->json($bookArray);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $book = $this->bookService->takeItBook($id);
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, BookStoreRequest $request)
    {
        $bookArray = $this->bookService->setBook($request, $id);
        return response()->json($bookArray);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $complete = $this->bookService->deleteBook($id);
        return response()->json(['complete'=>$complete]);
    }
}
