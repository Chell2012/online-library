<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
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
     * @param  Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        return  response()->json($this->publisherRepository->getById($publisher->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherUpdateRequest $request, Publisher $publisher)
    {
        $publisher = $this->publisherRepository->update($publisher->id, $request->title);
        return  response()->json($publisher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        return response()->json($this->publisherRepository->delete($publisher->id));
    }

    /**
     * Approve or deapprove author
     * 
     * @param  App\Http\Requests\ApproveRequest  $request
     * @param  Publisher $model
     * @return \Illuminate\Http\Response
     */
    public function approve(ApproveRequest $request, Publisher $model)
    {
        return response()->json($this->authorRepository->approve($request->approved, $model->id));
    }
}
