<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\BooksAuthors;
use App\Models\BooksTags;
use App\Models\Book;

/**
 *
 * @author vyacheslav
 */
interface BookRepositoryInterface {
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns): ?Collection;
    /**
     * 
     * @param int $id
     * @return array|null
     */
    public function takeItBook(int $id): ?array;
    /**
     * 
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book;
    /**
     * 
     * @param array $attributes
     * @return Book
     */
    public function newBook(array $attributes): Book;
    /**
     * 
     * @param int $id
     * @param array $attributes
     * @return Book
     */
    public function updateBook(int $id, array $attributes) : Book;
    /**
     * 
     * @param int $id
     * @return bool
     */
    public function deleteBook(int $id): bool;
    /**
     * Return Collection of book authors
     * @param int $bookId book id
     * @param bool $fullNames true - return authors with 'author' db record
     * @return Collection
     */
    public function getBookAuthors(int $bookId, bool $fullNames = false): ?Collection;
    
    /**
     * Return Collection of book tags
     * @param int $bookId book id
     * @param bool $fullTitle true - return tags with 'tag' db record
     * @return Collection|null
     */
    public function getBookTags(int $bookId, bool $fullTitle = false): ?Collection;
    
    /**
     * 
     * @param int $bookId
     * @param int $authorId
     * @return \App\Repositories\BooksAuthors
     */
    public function setBookAuthor(int $bookId, int $authorId): BooksAuthors;
    
    /**
     * 
     * @param int $bookId
     * @param int $tagId
     * @return \App\Repositories\BooksTags
     */
    public function setBookTag(int $bookId, int $tagId): BooksTags;
    /**
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteBookAuthors(int $bookId): bool;
    /**
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteBookTags(int $bookId): bool;
}
