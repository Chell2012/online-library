<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\PublisherRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
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
     * @return type
     */
    public function bookList() {
        $bookList = $this->bookRepository->getAll();
        return ['books'=>$bookList];
    }
    /**
     * 
     * @param int $id
     * @return type
     */
    public function takeItBook(int $id) {
        //TODO:Заджойнить имена авторов и теги
        return $this->bookRepository->getBookById($id);
    }

    /**
     * 
     * @param Request $request
     * @param BookRepository $bookRepository
     * @return Book|null
     */
//    public static function createBook(Request $request): ?Book{
//        $attributes = [
//            'title'=>$request->title,
//            'publisher_id'=> self::getPublisherId($request->publisher),
//            'year'=>$request->year,
//            'isbn'=>$request->isbn,
//            'category_id'=>self::getCategoryId($request->category),
//            'user_id'=>Auth::id(),
//            'link'=>$request->link,
//            'description'=>$request->description
//        ];
//        $book = $bookRepository->create($attributes);
//        $authors = self::setAuthors($request->authors, $bookRepository);
//        $tags = self::setTags($request->tags, $bookRepository);
//        If ($authors && $tags){
//            return $book;
//        }else{
//            return NULL;
//        }
//        
//    }

//    private static function setAuthors(string $authors): bool {
//        //TODO:Обработчик возможных ошибок надо бы сюда
//        
//        $executeCheck = true;
//        foreach (explode(',', $authors) as $author) {
//            $author = trim($author);
//            $fullNameArray = explode(' ', $author);
//            $fullName = [
//                'surname'=>$fullNameArray[0],
//                'name'=>$fullNameArray[1],
//                'middle_name'=> count($fullNameArray)>2? $fullNameArray[2] : NULL
//            ];
//            
//            $authorId = self::getAuthorId($fullName);
//            
//            if ($authorId != NULL && $bookRepository->getCurrentId()!=NULL) {
//                $bookRepository->setBookAuthor($bookRepository->getCurrentId(), $authorId);
//            } else {
//                $executeCheck = false;
//            }
//        }
//        return $executeCheck;
//    }
    
    /**
     * 
     * @param string $tags
     * @param BookRepository $bookRepository
     * @return bool|null
     */
//    private static function setTags(string $tags): bool {
//        //TODO:Обработчик возможных ошибок надо бы сюда
//        $executeCheck = true;
//        foreach (explode(',', $tags) as $tag) {
//            $tagTitle = trim($tag);
//            $tagId = self::getTagId($tagTitle);
//            
//            if ($tagId != NULL && $bookRepository->getCurrentId()!=NULL) {
//                $bookRepository->setBookTag($bookRepository->getCurrentId(), $tagId);
//            } else {
//                $executeCheck = false;
//            }
//        }
//        return $executeCheck;
//    }
    
    /**
     * 
     * @param type $fullName
     * @return int|null
     */
    private function getAuthorId(array $fullmaster): int {
        
        $author = $this->authorRepository->getAuthorByFullName($fullmaster);
        
        if ($author===NULL){
            $author = $this->authorRepository->newAuthor($fullmaster);
        }

        return $author->id;
    }
    
    /**
     * 
     * @param array $tagTitle
     * @return int
     */
    private function getTagId(string $tagTitle): int {
        
        $tag = $this->tagRepository->getTagByTitle($tagTitle);
        if ($tag===NULL){
            $tag = $this->tagRepository->newTag($tagTitle);
        }

        return $tag->id;
    }
    
    /**
     * 
     * @param string $categoryTitle
     * @return int
     */
    private function getCategoryId(string $categoryTitle): int {
        
        $category = $this->categoryRepository->getCategoryByTitle($categoryTitle);
        if ($category===NULL){
            $category = $this->categoryRepository->newCategory($categoryTitle);
        }

        return $category->id;
    }
    
    /**
     * 
     * @param string $publisherTitle
     * @return int
     */
    private function getPublisherId(string $publisherTitle): int {
        
        $publisher = $this->publisherRepository->getPublisherByTitle($publisherTitle);
        if ($publisher===NULL){
            $publisher = $this->publisherRepository->newPublisher($publisherTitle);
        }

        return $publisher->id;
    }

}
