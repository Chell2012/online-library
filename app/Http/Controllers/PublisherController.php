<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use \App\Repositories\PublisherRepositoryInterface;
use App\Http\Requests\PublisherStoreRequest;
use App\Http\Requests\PublisherUpdateRequest;

class PublisherController extends Controller
{
    private $publisherRepository;
    /**
     * 
     * @param PublisherRepositoryInterface $publisherRepository
     */
    public function __construct(PublisherRepositoryInterface $publisherRepository){
        $this->publisherRepository = $publisherRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->publisherRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublisherStoreRequest $request)
    {
        return response()->json($this->publisherRepository->new($request->title));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return  response()->json($this->publisherRepository->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherUpdateRequest $request, int $id)
    {
        $publisher = $this->publisherRepository->update($id, $request->title);
        return  response()->json($publisher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return response()->json($this->publisherRepository->delete($id));
    }
}
