<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Repositories\AuthorRepositoryInterface;
use App\DTO\AuthorDataTransferObject;
use App\Http\Requests\ApproveRequest;
use Carbon\Carbon;

class AuthorController extends Controller
{
    private $authorRepository;
    /**
     * 
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository){
        $this->authorRepository = $authorRepository;
        $this->authorizeResource(Author::class);
    }
    
    /**
     * Display a listing of approved resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->authorRepository->getAllApproved());
    }
    
    /**
     * Display a listing of all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewNotApproved()
    {
        return response()->json($this->authorRepository->getAll());
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
        $birth_date = new Carbon($request->birth_date);
        $death_date = new Carbon($request->death_date);
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            $birth_date,
            $death_date
        );
        return  response()->json($this->authorRepository->new($authorDTO));
    }

    /**
     * Approve or deapprove author
     * 
     * @param  App\Http\Requests\ApproveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(ApproveRequest $request)
    {
        return response()->json($this->authorRepository->approve($request->approved, $request->id));
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
        $birth_date = new Carbon($request->birth_date);
        $death_date = new Carbon($request->death_date);
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            $birth_date,
            $death_date
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
