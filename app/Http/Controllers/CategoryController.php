<?php

namespace App\Http\Controllers;

use App\DTO\CategoryDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     *
     * @param CategorySearchRequest $request
     * @return JsonResponse|Response
     */
    public function index(CategorySearchRequest $request)
    {
        $categoryDTO = new CategoryDataTransferObject(
            $request->title,
            ($request->user()->can('view-not-approved-'.Category::class)) ?
                (($request->approved!=null) ?
                    array_map(function($value) { return (int)$value; }, $request->approved) :
                    null
                ) :
                [1,2]
        );
        $categories = $this->categoryRepository->getBySearch($categoryDTO, $request->pagination===null ? true : $request->pagination);
        return ($request->return_json)?
            response()->json($categories) :
            response()->view('category.list',[
                'category_class'=>Category::class,
                'user'=>$request->user(),
                'approved_status'=>require_once database_path("data/status_list.php"),
                'categories'=>$categories,
                'pageTitle' => __('Категории'),
            ]);
    }

    /**
     * Show form for a new record
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('category.create', [
            'category_class'=>Category::class,
            'user'=>Auth::user(),
            'pageTitle' => __('Новая категория')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $categoryDTO = new CategoryDataTransferObject(
            $request->title
        );
        $category = $this->categoryRepository->new($categoryDTO);
        return response()->redirectToRoute('category.show',['category'=>$category->id])->with('success', 'Запись сохранена');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param bool $returnJson
     * @return JsonResponse|Response
     */
    public function show(Category $category, bool $returnJson = false)
    {
        $categoryCard = $this->categoryRepository->getById($category->id);
        return  ($returnJson)?
        response()->json($category) :
        response()->view('category.show',[
            'category_class'=>Category::class,
            'user'=>Auth::user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'category'=>$categoryCard,
            'pageTitle'=>$categoryCard->title
        ]);
    }

    /**
     * Show form for a new record
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category): Response
    {
        return response()->view('category.edit', [
            'category'=>$category,
            'pageTitle' => __('Редактирование '.$category->title)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest  $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $categoryDTO = new CategoryDataTransferObject(
            $request->title
        );
        $categoryUpdate = $this->categoryRepository->update($category->id, $categoryDTO);
        return  ($categoryUpdate)?
            response()->redirectToRoute('category.show', ['category'=>$categoryUpdate->id])->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        return ($this->categoryRepository->delete($category->id))?
        response()->redirectToRoute('category.index')->with('success', 'Запись удалена'):
        response()->redirectToRoute('category.index')->with('error', 'Что-то пошло не так');
    }

    /**
     * Approve or deapprove author
     *
     * @param  App\Http\Requests\ApproveRequest  $request
     * @return Response
     */
    public function approve(ApproveRequest $request)
    {
        return ($this->categoryRepository->approve($request->approved, $request->id))?
        redirect()->back()->with('success', 'Запись обновлена'):
        redirect()->back()->with('error', 'Что-то пошло не так');
    }
}
