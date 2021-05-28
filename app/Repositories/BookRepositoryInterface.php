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
     * @return Book|null
     */
    public function getBookById(int $id): ?array;
    
    /**
     * 
     * @param int $bookId
     * @return Collection
     */
    public function getBookAuthors(int $bookId): Collection;
    
    /**
     * 
     * @param int $bookId
     * @return Collection
     */
    
    public function getBookTags(int $bookId): Collection;
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
}
