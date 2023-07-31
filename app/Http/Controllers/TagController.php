<?php

namespace App\Http\Controllers;

use App\DTO\TagDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\TagSearchRequest;
use App\Models\Tag;
use App\Http\Requests\TagsStoreRequest;
use App\Http\Requests\TagsUpdateRequest;
use App\Models\Category;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    private $tagRepository;
    /**
     *
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository){
        $this->tagRepository = $tagRepository;
        $this->authorizeResource(Tag::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param TagSearchRequest $request
     * @return JsonResponse|Response
     */
    public function index(TagSearchRequest $request)
    {
        $tagDTO = new TagDataTransferObject(
            $request->title,
            $request->category_id,
            ($request->user()->can('view-not-approved-'.Tag::class)) ?
                (($request->approved!=null) ?
                    array_map(function($value) { return (int)$value; }, $request->approved) :
                    null
                ) :
                [1,2]
        );
        $tags = $this->tagRepository->getBySearch($tagDTO, $request->pagination===null ? true : $request->pagination);
        return ($request->return_json)?
            response()->json($tags) :
            response()->view('tag.list',[
                'approves_list'=>$request->approved,
                'tag_class'=>Tag::class,
                'user'=>$request->user(),
                'approved_status'=>require_once database_path("data/status_list.php"),
                'tags'=>$tags,
                'pageTitle' => __('Темы'),
        ]);
    }

    /**
     * Show form for a new record
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('tag.create', [
            'author_class'=>Tag::class,
            'user'=>Auth::user(),
            'pageTitle' => __('Новая тема')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagsStoreRequest $request
     * @return RedirectResponse
     */
    public function store(TagsStoreRequest $request): RedirectResponse
    {
        $tagDTO = new TagDataTransferObject(
            $request->title,
            $request->category_id
        );
        $tag = $this->tagRepository->new($tagDTO);
        return response()->redirectToRoute('tag.show',['tag'=>$tag->id])->with('success', 'Запись сохранена');
    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @param bool $returnJson
     * @return JsonResponse|Response
     */
    public function show(Tag $tag, bool $returnJson = false)
    {
        $tagCard = $this->tagRepository->getById($tag->id);
        return  ($returnJson)?
            response()->json($tag) :
            response()->view('tag.show',[
            'tag_class'=>Tag::class,
            'user'=>Auth::user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'tag'=>$tagCard,
            'pageTitle'=>$tagCard->title
        ]);
    }

    /**
     * Show form for a new record
     *
     * @param Tag $tag
     * @return Response
     */
    public function edit(Tag $tag): Response
    {
        return response()->view('tag.edit', [
            'category'=>$tag->category()->first(),
            'tag'=>$tag,
            'pageTitle' => __('Редактирование '.$tag->title)
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param TagsUpdateRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(TagsUpdateRequest $request, Tag $tag): RedirectResponse
    {
        $tagDTO = new TagDataTransferObject(
            $request->title,
            $request->category_id
        );
        $tagUpdate = $this->tagRepository->update($tag->id, $tagDTO);
        return ($tagUpdate)?
            response()->redirectToRoute('tag.show', ['tag'=>$tagUpdate->id])->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        return ($this->tagRepository->delete($tag->id))?
            response()->redirectToRoute('tag.index')->with('success', 'Запись удалена'):
            response()->redirectToRoute('tag.index')->with('error', 'Что-то пошло не так');
    }
    /**
     * Approve or deapprove author
     *
     * @param  ApproveRequest  $request
     * @return RedirectResponse
     */
    public function approve(ApproveRequest $request): RedirectResponse
    {
        return ($this->tagRepository->approve($request->approved, $request->id))?
            redirect()->back()->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }
}
