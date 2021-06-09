<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagsStoreRequest;
use App\Http\Requests\TagsUpdateRequest;
use App\Repositories\TagRepositoryInterface;

class TagController extends Controller
{
    private $tagRepository;
    /**
     * 
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository){
        $this->tagRepository = $tagRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->tagRepository->getAll());
    }
    /**
     * Store a newly created resource in storage.   
     *
     * @param \App\Http\Requests\TagsStoreRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function store(TagsStoreRequest $request)
    {
        return response()->json($this->tagRepository->new($request->title, $request->category_id));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return  response()->json($this->tagRepository->getById($tag->id));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TagsUpdateRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagsUpdateRequest $request, Tag $tag)
    {
        return response()->json($this->tagRepository->update($tag->id, $request->title, $request->category_id));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        return response()->json($this->tagRepository->delete($tag->id));
    }
}
