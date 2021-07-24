<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Repositories\AuthorRepositoryInterface;
use App\DTO\AuthorDataTransferObject;
use App\Http\Requests\ApproveRequest;

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
        $authorList = $this->authorRepository->getAll();
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
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            $request->birth_date,
            $request->death_date
        );
        return  response()->json($this->authorRepository->new($authorDTO));
    }

    /**
     * Approve or deapprove author
     * 
     * @param  App\Http\Requests\ApproveRequest  $request
     * @param  Author $author
     * @return \Illuminate\Http\Response
     */
    public function approve(ApproveRequest $request, Author $author)
    {
        return response()->json($this->authorRepository->approve($request->approved, $author->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return response()->json($this->authorRepository->getById($author->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AuthorUpdateRequest  $request
     * @param  Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            $request->birth_date,
            $request->death_date
        );
        return response()->json($this->authorRepository->update($author->id, $authorDTO));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Author $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        return response()->json($this->authorRepository->delete($author->id));
    }
}
