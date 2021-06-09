<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\PublisherRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\DTO\BookDataTransferObject;

/**
 * Description of BookService
 *
 * @author vyacheslav
 */
class BookService 
{
    private $bookRepository;
    private $authorRepository;
    private $categoryRepository;
    private $publisherRepository;
    private $tagRepository;

    /**
     * 
     * @param BookRepositoryInterface $bookRepository
     * @param AuthorRepositoryInterface $authorRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param PublisherRepositoryInterface $publisherRepository
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(
        BookRepositoryInterface $bookRepository,
        AuthorRepositoryInterface $authorRepository,
        CategoryRepositoryInterface $categoryRepository,
        PublisherRepositoryInterface $publisherRepository,
        TagRepositoryInterface $tagRepository
    ){
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->categoryRepository = $categoryRepository;
        $this->publisherRepository = $publisherRepository;
        $this->tagRepository = $tagRepository;
    }
    /**
     * Return collection of records
     * 
     * @return Collection|null  
     */
    public function list(): ?Collection
    {
        return $this->bookRepository->getAll();
    }
    /**
     * Return book with tags and authors
     * 
     * @param int $id
     * @return array|null
     */
    public function getWithRelations(int $id): ?array
    {
        return $this->bookRepository->getWithRelations($id);
    }
    /**
     * Create new book and relations
     * 
     * @param BookDataTransferObject $bookDTO
     * @return array|null
     */
    public function new(BookDataTransferObject $bookDTO): ?array
    {
        $book = $this->bookRepository->new(Auth::id(), $bookDTO);
        if (!isset($book)){
            return null;
        }
        $authors = $this->setAuthors($book->id, $bookDTO->getAuthorsIds());
        $tags = $this->setTags($book->id, $bookDTO->getTagsIds());
        return  [
        'book'=>$book,
        'authors'=>$authors,
        'tags'=>$tags
        ];
    }
    /**
     * Update book and relations if it exists
     * 
     * @param BookDataTransferObject $bookDTO
     * @param int $id
     * @return array|null
     */
    public function update(BookDataTransferObject $bookDTO, int $id): ?array
    {
        $book = $this->bookRepository->update($id, Auth::id(), $bookDTO);
        if (!isset($book)){
            return null;
        }
        $authors = $this->setAuthors($book->id, $bookDTO->getAuthorsIds());
        $tags = $this->setTags($book->id, $bookDTO->getTagsIds());
        return  [
        'book'=>$book,
        'authors'=>$authors,
        'tags'=>$tags
        ];
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
}
