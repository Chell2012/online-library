<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorSearchRequest;
use App\Models\Author;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Repositories\AuthorRepositoryInterface;
use App\DTO\AuthorDataTransferObject;
use App\Http\Requests\ApproveRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of resources.
     *
     * @param AuthorSearchRequest|null $request
     * @param bool $returnJson
     * @return JsonResponse|Response
     */
    public function index(AuthorSearchRequest $request, bool $returnJson = false)
    {
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            ($request->birth_date!=null)?Carbon::parse($request->birth_date):null,
            ($request->death_date!=null)?Carbon::parse($request->death_date):null,
            ($request->user()->can('view-not-approved-'.Author::class)) ?
                (($request->approved!=null) ?
                    array_map(function($value) { return (int)$value; }, $request->approved) :
                    null
                ) :
                [1,2]
        );
        $authors = $this->authorRepository->getBySearch($authorDTO, $request->pagination===null ? true : $request->pagination);
        return ($request->return_json)?
            response()->json($authors) :
            response()->view('author.list',[
                'approves_list'=>$request->approved,
                'author_class'=>Author::class,
                'user'=>$request->user(),
                'approved_status'=>require_once database_path("data/status_list.php"),
                'authors'=>$authors,
                'pageTitle' => __('Авторы'),
        ]);
    }

    /**
     * Show form for a new record
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('author.create', [
            'author_class'=>Author::class,
            'user'=>Auth::user(),
            'pageTitle' => __('Новый автор')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorStoreRequest $request
     * @return RedirectResponse
     */
    public function store(AuthorStoreRequest $request): RedirectResponse
    {
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            ($request->birth_date!=null)?Carbon::parse($request->birth_date):null,
            ($request->death_date!=null)?Carbon::parse($request->death_date):null,
        );
        $author = $this->authorRepository->new($authorDTO);
        return ($author!=null) ?
            response()->redirectToRoute('author.show', ['author'=>$author->id])->with('success', 'Запись сохранена') :
            redirect()->back()->with('error','Проверьте введённые данные');
    }

    /**
     * Approve or deapprove author
     *
     * @param ApproveRequest $request
     * @return RedirectResponse
     */
    public function approve(ApproveRequest $request): RedirectResponse
    {
        return ($this->authorRepository->approve($request->approved, $request->id))?
            redirect()->back()->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @param bool $returnJson
     * @return JsonResponse|Response
     */
    public function show(Author $author, bool $returnJson = false)
    {
        $authorCard = $this->authorRepository->getById($author->id);
        return ($returnJson)?
            response()->json($authorCard) :
            response()->view('author.show',[
            'author_class'=>Author::class,
            'user'=>Auth::user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'author'=>$authorCard,
            'pageTitle' => __($authorCard->surname.' '.$authorCard->name.' '.$authorCard->middle_name)
        ]);
    }

    /**
     * Show form for a new record
     *
     * @param Author $author
     * @return Response
     */
    public function edit(Author $author): Response
    {
        return response()->view('author.edit', [
            'author'=>$author,
            'pageTitle' => __('Редактирование '.$author->surname.' '.$author->name.' '.$author->middle_name)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorUpdateRequest $request
     * @param Author $author
     * @return RedirectResponse
     */
    public function update(AuthorUpdateRequest $request, Author $author): RedirectResponse
    {
        $authorDTO = new AuthorDataTransferObject(
            $request->name,
            $request->surname,
            $request->middle_name,
            ($request->birth_date!=null)?Carbon::parse($request->birth_date):null,
            ($request->death_date!=null)?Carbon::parse($request->death_date):null,
        );
        $authorUpdate = $this->authorRepository->update($author->id, $authorDTO);
        return ($authorUpdate)?
            response()->redirectToRoute('author.show', ['author'=>$authorUpdate->id])->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Author $author
     * @return RedirectResponse
     */
    public function destroy(Author $author): RedirectResponse
    {
        return ($this->authorRepository->delete($author->id))?
            response()->redirectToRoute('author.index')->with('success', 'Запись удалена'):
            response()->redirectToRoute('author.index')->with('error', 'Что-то пошло не так');
    }
}
