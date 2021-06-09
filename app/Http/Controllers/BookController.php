<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Services\BookService;
use App\DTO\BookDataTransferObject;

class BookController extends Controller
{
    private $bookService;
    
    public function __construct(BookService $bookService)
    {
        $this->bookService=$bookService;
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json($this->bookService->getWithRelations($id));
    }
    /**
     * Update the specified resource in storage.
     * 
     * @param int $id
     * @param BookStoreRequest $request
     * @return type
     */
    public function update(int $id, BookStoreRequest $request)
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
                ), $id);
        return response()->json($bookArray);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return response()->json($this->bookService->delete($id));
    }
}
