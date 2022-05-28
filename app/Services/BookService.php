<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Description of BookService
 *
 * @author vyacheslav
 */
class BookService
{
    private $bookRepository;

    /**
     *
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository){
        $this->bookRepository = $bookRepository;
    }
    /**
     * Return book with tags and authors
     *
     * @param int $id
     * @return Book|null
     */
    public function getById(int $id): ?Book
    {
        return $this->bookRepository->getById($id);
    }
    /**
     * Return collection of books after filter
     *
     * @param FilterDataTransferObject $filter
     * @return LengthAwarePaginator|null
     */
    public function filter(FilterDataTransferObject $filter, bool $paginate = true, array $columns = ['*']): ?LengthAwarePaginator
    {
        return $this->bookRepository->getBySearch($filter, $paginate, $columns);
    }
    /**
     * Create new book and relations
     *
     * @param BookDataTransferObject $bookDTO
     * @return Book|null
     */
    public function new(BookDataTransferObject $bookDTO, int $userID): ?Book
    {
        $book = $this->bookRepository->new($userID, $bookDTO);
        if (!isset($book)){
            return null;
        }
        if ($bookDTO->getAuthorsIds()!=null){
            $this->setAuthors($book->id, $bookDTO->getAuthorsIds());
        }
        if ($bookDTO->getTagsIds()!=null){
            $this->setTags($book->id, $bookDTO->getTagsIds());
        }
        return  $book;
    }
    /**
     * Update book and relations if it exists
     *
     * @param BookDataTransferObject $bookDTO
     * @param int $id
     * @return Book|null
     */
    public function update(BookDataTransferObject $bookDTO, int $id): ?Book
    {
        $book = $this->bookRepository->update($id, Auth::id(), $bookDTO);
        if (!isset($book)){
            return null;
        }
        if ($bookDTO->getAuthorsIds()!=null){
            $this->setAuthors($book->id, $bookDTO->getAuthorsIds());
        }
        if ($bookDTO->getTagsIds()!=null){
            $this->setTags($book->id, $bookDTO->getTagsIds());
        }
        return  $book;
    }
    /**
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return isset($id)?$this->bookRepository->delete($id):false;
    }

    /**
     * Create book-author relations
     *
     * @param int $bookId
     * @param array $authors
     * @return Collection|null
     */
    private function setAuthors(int $bookId, array $authors = null): ?Collection
    {
        $this->bookRepository->deleteAuthorRelations($bookId);
        if($authors!=null){
            foreach ($authors as $authorId) {
                $this->bookRepository->setAuthorRelation($bookId, $authorId);
            }
        }

        return $this->bookRepository->getAuthorRelations($bookId, true);
    }

    /**
     * Create book-tag relations
     *
     * @param int $bookId
     * @param array $tags
     * @return Collection|null
     */
    private function setTags(int $bookId, array $tags = null): ?Collection
    {
        $this->bookRepository->deleteTagRelations($bookId);
        if($tags!=null){
            foreach ($tags as $tagId) {
                $this->bookRepository->setTagRelation($bookId, $tagId);
            }
        }
        return $this->bookRepository->getTagRelations($bookId, true);
    }
    /**
     * Approve or deapprove published record
     *
     * @param int $approved
     * @param int $id
     * @return bool
     */
    public function approve(int $approved, int $id): bool
    {
        return $this->bookRepository->approve($approved, $id);
    }
    /**
     * Add books from yandex api
     * 
     * @param string $path
     * @param int $userID
     * @return bool
     */
    public function yandexBooksLoader(string $path, int $userID) :bool
    {
        $offset = 0;
        $lastDate = $this->bookRepository->getLastDateFrom($path);
        do {
            $response = Http::get('https://cloud-api.yandex.net/v1/disk/public/resources', [
                'public_key' => $path,
                'limit' => 20,
                'offset'=> $offset,
                'sort'=> "-created"
            ]);
            $total = $response["_embedded"]["total"];
            $offset = $response["_embedded"]["offset"];
            $items = $response["_embedded"]["items"];
            foreach ($items as $id => $item){
                if ($item["type"] == "file"){
                    if (Carbon::createFromFormat("Y-m-d\TH:i:sP", $item["created"])<=$lastDate) {
                        return true;
                    } else {
                        $bookDTO = new BookDataTransferObject(
                            $item["name"],
                            1,
                            null,
                            null,
                            1,
                            $response["public_url"].$item["path"],
                            null,
                            null,
                            null,
                            $path
                        );
                        if ($this->new($bookDTO, $userID) == null){
                            return false;
                        }
                        //TODO: обработать ошибку на случай, если не добавилось надо бы
                    }
                }
            }
            $offset+=20;
        } while ($offset<$total);
        return true;
    }
}
