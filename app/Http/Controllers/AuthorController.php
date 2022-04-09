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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index(AuthorSearchRequest $request): Response
    {
        if ($request->user()->can('view-not-approved-'.Author::class)){
            $authorDTO = new AuthorDataTransferObject(
                $request->name,
                $request->surname,
                $request->middle_name,
                ($request->birth_date!=null)?Carbon::parse($request->birth_date):null,
                ($request->death_date!=null)?Carbon::parse($request->death_date):null,
                ($request->approved!=null)?array_map(function($value) { return (int)$value; }, $request->approved):null
            );
        }else{
            $authorDTO = new AuthorDataTransferObject(
                $request->name,
                $request->surname,
                $request->middle_name,
                ($request->birth_date!=null)?Carbon::parse($request->birth_date):null,
                ($request->death_date!=null)?Carbon::parse($request->death_date):null,
                [1,2]
            );
        }
        $authors = $this->authorRepository->getBySearch($authorDTO);
        return response()->view('author.list',[
            'approved_status'=>require_once database_path("data/status_list.php"),
            'authors'=>$authors,
            'pageTitle' => __('Авторы'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param AuthorStoreRequest $request
     * @return Response
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
     * @param ApproveRequest $request
     * @return Response
     */
    public function approve(ApproveRequest $request)
    {
        return response()->json($this->authorRepository->approve($request->approved, $request->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return Response
     */
    public function show(Author $author)
    {
        return response()->json($this->authorRepository->getById($author->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorUpdateRequest $request
     * @param Author $author
     * @return Response
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
     * @return Response
     */
    public function destroy(Author $author)
    {
        return response()->json($this->authorRepository->delete($author->id));
    }
}
