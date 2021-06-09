<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Repositories\AuthorRepositoryInterface;
use App\DTO\AuthorDataTransferObject;

class AuthorController extends Controller
{
    private $authorRepository;
    /**
     * 
     * @param AuthorRepositoryInterface $authorRepository
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
        return response()->json($authorList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @param AuthorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name
        );
        return  response()->json($this->authorRepository->new($author));
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json($this->authorRepository->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AuthorUpdateRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, int $id)
    {
        $author = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name
        );
        return response()->json($this->authorRepository->update($id, $author));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return response()->json($this->authorRepository->delete($id));
    }
}
