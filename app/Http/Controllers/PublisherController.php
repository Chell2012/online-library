<?php

namespace App\Http\Controllers;

use App\DTO\PublisherDataTransferObject;
use App\Http\Requests\ApproveRequest;
use App\Http\Requests\PublisherSearchRequest;
use App\Models\Publisher;
use \App\Repositories\PublisherRepositoryInterface;
use App\Http\Requests\PublisherStoreRequest;
use App\Http\Requests\PublisherUpdateRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PublisherController extends Controller
{
    private $publisherRepository;
    /**
     * 
     * @param PublisherRepositoryInterface $publisherRepository
     */
    public function __construct(PublisherRepositoryInterface $publisherRepository){
        $this->publisherRepository = $publisherRepository;
        $this->authorizeResource(Publisher::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PublisherSearchRequest $request)
    {
        $publisherDTO = new PublisherDataTransferObject(
            $request->title,
            ($request->user()->can('view-not-approved-'.Publisher::class)) ?
                (($request->approved!=null) ?
                    array_map(function($value) { return (int)$value; }, $request->approved) :
                    null
                ) :
                [1,2]
        );
        $publishers = $this->publisherRepository->getBySearch($publisherDTO, $request->pagination===null ? true : $request->pagination);
        return ($request->return_json)?
            response()->json($publishers) :
            response()->view('publisher.list',[
                'approves_list'=>$request->approved,
                'publisher_class'=>Publisher::class,
                'user'=>$request->user(),
                'approved_status'=>require_once database_path("data/status_list.php"),
                'publishers'=>$publishers,
                'pageTitle' => __('Издатели'),
            ]);
    }

    /**
     * Show form for a new record
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('publisher.create', [
            'author_class'=>Publisher::class,
            'user'=>Auth::user(),
            'pageTitle' => __('Новый издатель')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(PublisherStoreRequest $request)
    {
        $publisherDTO = new PublisherDataTransferObject(
            $request->title
        );
        $publisher = $this->publisherRepository->new($publisherDTO);
        return response()->redirectToRoute('publisher.show',['publisher'=>$publisher->id])->with('success', 'Запись сохранена');
    }

    /**
     * Display the specified resource.
     *
     * @param  Publisher $publisher
     * @param bool $returnJson
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher, bool $returnJson = false)
    {
        $publisherCard = $this->publisherRepository->getById($publisher->id);
        return  ($returnJson)?
        response()->json($publisher) :
        response()->view('publisher.show',[
            'publisher_class'=>Publisher::class,
            'user'=>Auth::user(),
            'approved_status'=>require_once database_path("data/status_list.php"),
            'publisher'=>$publisherCard,
            'pageTitle'=>$publisherCard->title
        ]);
    }

    /**
     * Show form for a new record
     *
     * @param Publisher $publisher
     * @return Response
     */
    public function edit(Publisher $publisher): Response
    {
        return response()->view('publisher.edit', [
            'publisher'=>$publisher,
            'pageTitle' => __('Редактирование '.$publisher->title)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PublisherUpdateRequest  $request
     * @param  Publisher $publisher
     * @return RedirectResponse
     */
    public function update(PublisherUpdateRequest $request, Publisher $publisher)
    {
        $publisherDTO = new PublisherDataTransferObject(
            $request->title
        );
        $publisherUpdate = $this->publisherRepository->update($publisher->id, $publisherDTO);
        return  ($publisherUpdate)?
            response()->redirectToRoute('publisher.show', ['publisher'=>$publisherUpdate->id])->with('success', 'Запись обновлена'):
            redirect()->back()->with('error', 'Что-то пошло не так');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Publisher $publisher
     * @return Response
     */
    public function destroy(Publisher $publisher)
    {
        return ($this->publisherRepository->delete($publisher->id))?
        response()->redirectToRoute('publisher.index')->with('success', 'Запись удалена'):
        response()->redirectToRoute('publisher.index')->with('error', 'Что-то пошло не так');    
    }

    /**
     * Approve or deapprove author
     * 
     * @param  App\Http\Requests\ApproveRequest  $request
     * @return Response
     */
    public function approve(ApproveRequest $request)
    {
        return ($this->publisherRepository->approve($request->approved, $request->id))?
        redirect()->back()->with('success', 'Запись обновлена'):
        redirect()->back()->with('error', 'Что-то пошло не так');
    }
}
