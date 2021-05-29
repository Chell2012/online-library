<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Book;
use App\Models\BooksAuthors;
use App\Models\BooksTags;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of BookRepository
 *
 * @author vyacheslav
 */
class BookRepository implements BookRepositoryInterface{
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection {
        return Book::all($columns);
    }
    
    /**
     * 
     * @param int $id
     * @return array|null
     */
    public function getBookById(int $id): ?Book{
        return Book::query()->find($id);
        
    }
    /**
     * 
     * @param int $id
     * @return array|null
     */
    public function takeItBook(int $id): ?array{
        $book = $this->getBookById($id);
        $authors = $this->getBookAuthors($id, true);
        $tags = $this->getBookTags($id, true);
        return isset($book)?[
            'book'=>$book,
            'authors'=>$authors,
            'tags'=>$tags
        ]:null;
    }
    
    /**
     * 
     * @param array $attributes
     * @return Book
     */
    public function newBook(array $attributes): Book {
        return Book::query()->create($attributes);
    }
    /**
     * 
     * @param int $id
     * @param array $attributes
     * @return Book
     */
    public function updateBook(int $id, array $attributes) : Book {
        $book = $this->getBookById($id);
        $book->title = $attributes['title'];
        $book->publisher_id = $attributes['publisher_id'];
        $book->year = $attributes['year'];
        $book->isbn = $attributes['isbn'];
        $book->category_id = $attributes['category_id'];
        $book->user_id = $attributes['user_id'];
        $book->link = $attributes['link'];
        $book->description = $attributes['description'];
        $book->save();
        return $book;
    }
    /**
     * 
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool {
        if ($this->getBookById($id)!=null){
            $rmBook = $this->getBookById($id)->delete();
            return $rmBook;
        }
        return false;
    }
    /**
     * Return Collection of book authors
     * @param int $bookId
     * @param bool $fullNames true - return authors with 'author' db record
     * @return Collection
     */
    public function getBookAuthors(int $bookId, bool $fullNames = false): ?Collection {
        if ($fullNames) {
            return BooksAuthors::query()->where('book_id', $bookId)->with('author')->get();
            
        }
        return BooksAuthors::query()->where('book_id', $bookId)->get();
    }
    /**
     * Return Collection of book tags
     * @param int $bookId
     * @param bool $fullTitle
     * @return Collection
     */
    public function getBookTags(int $bookId, bool $fullTitle = false): ?Collection {
        if($fullTitle){
            return BooksTags::query()->where('book_id', $bookId)->with('tag')->get();
        }
        return BooksTags::query()->where('book_id', $bookId)->get();
    }
    
    /**
     * 
     * @param int $bookId
     * @param int $authorId
     * @return BooksAuthors
     */
    public function setBookAuthor(int $bookId, int $authorId): BooksAuthors{
        return BooksAuthors::query()->firstOrCreate([
            'book_id'=>$bookId,
            'author_id'=>$authorId
        ]);
    }
    /**
     * 
     * @param int $bookId
     * @param int $tagId
     * @return BooksTags
     */
    public function setBookTag(int $bookId, int $tagId): BooksTags{
        return BooksTags::query()->firstOrCreate([
            'book_id'=>$bookId,
            'tag_id'=>$tagId
        ]);
    }
    /**
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteBookAuthors(int $bookId): bool {
        return BooksAuthors::query()->where('book_id', $bookId)->delete();
    }
    /**
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteBookTags(int $bookId): bool {
        return BooksTags::query()->where('book_id', $bookId)->delete();
    }
}
