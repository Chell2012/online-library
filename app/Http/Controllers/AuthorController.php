<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Repositories\AuthorRepositoryInterface;

class AuthorController extends Controller
{
    private $authorRepository;
    /**
     * 
     * @param \App\Http\Controllers\AuthorRepositoryInterface $authorRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository){
        $this->authorRepository = $authorRepository;
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorList = $this->authorRepository->getAll(['id', 'name', 'middle_name', 'surname']);
        return response()->json(['authors'=>$authorList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @param AuthorStoreRequest $request
     * @return type
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = $this->authorRepository->newAuthor([
            'name'=>$request->name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name
        ]);
        return  response()->json(['author'=>$author]);
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param Author $author
     * @return type
     */
    public function show(int $id)
    {
        $author = $this->authorRepository->getAuthorById($id);
        return response()->json(['author'=>$author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AuthorUpdateRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, int $id)
    {
        $author = $this->authorRepository->updateAuthor($id,[
            'name'=>$request->name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name
        ]);
        return response()->json(['author'=>$author]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $complete = $this->authorRepository->deleteAuthor($id);
        return response()->json(['complete'=>$complete]);
    }
}
