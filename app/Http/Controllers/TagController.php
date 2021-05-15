<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagsStoreRequest;
use App\Http\Requests\TagsUpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagsList = Tag::all('id', 'title');
        return response()->json(['tags'=>$tagsList]);
    }

    /**
     * Store a newly created resource in storage.   
     *
     * @param \App\Http\Requests\TagsStoreRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function store(TagsStoreRequest $request)
    {
        $tag = new Tag;
        $tag->title = $request->title;
        $tag->category_id = $request->category_id;
        $tag->save();
        return  response()->json(['tag'=>$tag]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return  response()->json(['tag'=>$tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagsUpdateRequest $request, Tag $tag)
    {
        if ($request->title) {$tag->title = $request->title;}
        if ($request->category_id) {$tag->category_id = $request->category_id;}
        $tag ->save();
        return  response()->json(['tag'=>$tag]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['complete'=>true]);
    }
}
