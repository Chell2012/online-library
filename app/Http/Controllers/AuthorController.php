<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorList = Author::all('id', 'name','middle_name','surname');
        return response()->json(['authors'=>$authorList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\AuthorStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = new Author;
        $author->name = $request->name;
        $author->surname = $request->surname;
        $author->middle_name = $request->middle_name;
        $author->save();
        return  response()->json(['author'=>$author]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
       return response()->json(['author'=>$author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AuthorUpdateRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        if ($request->name) {$author->name = $request->name;}
        if ($request->middle_name) {$author->middle_name = $request->middle_name;}
        if ($request->surname) {$author->surname = $request->surname;}
        $author ->save();
        return response()->json(['author'=>$author]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(['complete'=>true]);
    }
}
