<?php

namespace App\Http\Controllers;

use App\DTO\CategoryDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private $categoryRepository;
    /**
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
        $this->authorizeResource(Category::class);
    }

    /**
     * Display a listing of all resources.
     *
     * @return Response
     */
    public function viewNotApproved()
    {
        return response()->json($this->categoryRepository->getAll());
    }

    /**
     * Display a listing of the resource.
     *
     * @param CategorySearchRequest $request
     * @return JsonResponse|Response
     */
    public function index(CategorySearchRequest $request)
    {
        $categoryDTO = new CategoryDataTransferObject(
            $request->title
        );
        return
            ($request->return_json)?
                response()
                    ->json($this->categoryRepository
                    ->getBySearch($categoryDTO,$request->pagination===null ? true : $request->pagination)) :
                response()->view('category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return Response
     */
    public function store(CategoryStoreRequest $request)
    {
        return response()->json($this->categoryRepository->new($request->title));
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        return  response()->json($this->categoryRepository->getById($category->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Category $category
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        return  response()->json($this->categoryRepository->update($category->id, $request->title));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        return response()->json($this->categoryRepository->delete($category->id));
    }

    /**
     * Approve or deapprove author
     *
     * @param  App\Http\Requests\ApproveRequest  $request
     * @return Response
     */
    public function approve(ApproveRequest $request)
    {
        return response()->json($this->categoryRepository->approve($request->approved, $request->id));
    }
}
