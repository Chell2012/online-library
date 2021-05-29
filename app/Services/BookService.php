<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Http\Requests\BookStoreRequest;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\PublisherRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Description of BookService
 *
 * @author vyacheslav
 */
class BookService {
    
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
            ) {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->categoryRepository = $categoryRepository;
        $this->publisherRepository = $publisherRepository;
        $this->tagRepository = $tagRepository;
    }
    /**
     * 
     * @return array|null
     */
    public function bookList(): ?array{
        $bookList = $this->bookRepository->getAll();
        return isset($bookList)?['books'=>$bookList]:null;
    }
    /**
     * 
     * @param int $id
     * @return array|null
     */
    public function takeItBook(int $id): ?array {
        return $this->bookRepository-> takeItBook($id);
    }

    /**
     * 
     * @param Request $request
     * @param int $id
     * @return array|null
     */
    public function setBook(BookStoreRequest $request, int $id = null): ?array{
        $attributes = [
            'title'=>$request->title,
            'publisher_id'=>  isset($request->publisher)?$this->publisherRepository->getPublisherId($request->publisher):null,
            'year'=>$request->year,
            'isbn'=>$request->isbn,
            'category_id'=> isset($request->category)?$this->categoryRepository->getCategoryId($request->category):null,
            'user_id'=>Auth::id(),
            'link'=>$request->link,
            'description'=>$request->description
        ];
        if (!isset($id)){
            $book = $this->bookRepository->newBook($attributes);
        }
        else{
            $book = $this->bookRepository->updateBook($id, $attributes);
        }
        if (isset($book)){
            $authors = $this->setAuthors($book->id, $request->authors);
            $tags = $this->setTags($book->id, $request->tags);
            return  [
            'book'=>$book,
            'authors'=>$authors,
            'tags'=>$tags
            ];
        }
        return null;
    }
    /**
     * 
     * @param int $id
     * @return bool|null
     */
    public function deleteBook(int $id): ?bool{
        return isset($id)?$this->bookRepository->deleteBook($id):false;
    }

    /**
     * 
     * @param int $bookId
     * @param array $authors
     * @return Collection|null
     */
    private function setAuthors(int $bookId, array $authors = null): ?Collection {
        $this->bookRepository->deleteBookAuthors($bookId);
        if($authors!=null){
            foreach ($authors as $author) {
                $authorId = $this->authorRepository->getAuthorId($author);
                $this->bookRepository->setBookAuthor($bookId, $authorId);
            }
        }
        
        return $this->bookRepository->getBookAuthors($bookId, true);
    }
    
    /**
     * 
     * @param int $bookId
     * @param array $tags
     * @return Collection|null
     */
    private function setTags(int $bookId, array $tags = null): ?Collection {
        $this->bookRepository->deleteBookTags($bookId);
        if($tags!=null){
            foreach ($tags as $tag) {
                $tagId = $this->tagRepository->getTagId($tag);
                $this->bookRepository->setBookTag($bookId, $tagId);
            }
        }
        return $this->bookRepository->getBookTags($bookId, true);
    }

}
