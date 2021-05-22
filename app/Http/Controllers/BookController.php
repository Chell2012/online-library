<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Repositories\BookRepository;

class BookController extends Controller
{
    private $bookRepository;
    
    public function __construct(BookRepository $bookRepository)
   {
       $this->bookRepository = $bookRepository;
   }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookList = $this->bookRepository->all();
        return response()->json(['books'=>$bookList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book;
        $book->title = $request->title;
        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->year = $request->year;
        $book->isbn = $request->isbn;
        $book->user_id = \Illuminate\Support\Facades\Auth::id();
        $book->link = $request->link;
        $book->description = $request->description;
        $book->save();
        $tags = explode(',', $request->tags);
        foreach ($tags as $tag_title){
            $book->tags()->book_id = $book->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
