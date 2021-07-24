<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    private $categoryRepository;
    /**
     * 
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->categoryRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        return response()->json($this->categoryRepository->new($request->title));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return  response()->json($this->categoryRepository->getById($category->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        return  response()->json($this->categoryRepository->update($category->id, $request->title));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return response()->json($this->categoryRepository->delete($category->id));
    }

    /**
     * Approve or deapprove author
     * 
     * @param  App\Http\Requests\ApproveRequest  $request
     * @param  Category $model
     * @return \Illuminate\Http\Response
     */
    public function approve(ApproveRequest $request, Category $model)
    {
        return response()->json($this->authorRepository->approve($request->approved, $model->id));
    }
}
