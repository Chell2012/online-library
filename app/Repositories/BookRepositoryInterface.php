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
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

/**
 *
 * @author vyacheslav
 */
interface BookRepositoryInterface
{
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return  LengthAwarePaginator|null
     */
    public function getAll($columns = ['*']): ?LengthAwarePaginator;

    /**
     * Return collection of books after filter
     * 
     * @param FilterDataTransferObject $filter
     * @param bool $paginate
     * @param array $columns
     * @return Collection|LengthAwarePaginator
     */
    public function getBySearch(FilterDataTransferObject $filter, bool $paginate = true, array $columns = ['*']);
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Book|null
     */
    public function getById(int $id): ?Book;
    /**
     * Get last loading date from specific source
     * @param string $source
     * @return Carbon|null
     */
    public function getLastDateFrom(string $source): ?Carbon;
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param int $userId
     * @param BookDataTransferObject $BookDTO
     * @return Book|null
     */
    public function update(int $id, int $userId, BookDataTransferObject $BookDTO): ?Book;
    /**
     * Create new record
     * 
     * @param int $userId
     * @param BookDataTransferObject $BookDTO
     * @return Book|null
     */
    public function new(int $userId, BookDataTransferObject $BookDTO): ?Book;
    /**
     * Delete book with that id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    /**
     * Approve or deapprove published record
     * 
     * @param int $approved
     * @param int $id
     * @return bool
     */
    public function approve(int $approved, int $id): bool;
    /**
     * Return Collection of book authors
     * 
     * @param int $bookId
     * @param bool $fullNames true - return authors with 'author' db record
     * @return Collection
     */
    public function getAuthorRelations(int $bookId): ?Collection;
    /**
     * Return Collection of book tags
     * 
     * @param int $bookId
     * @param bool $fullTitle
     * @return Collection
     */
    public function getTagRelations(int $bookId): ?Collection;
    /**
     * Find or create book-author relation
     * 
     * @param int $bookId
     * @param int $authorId
     * @return BooksAuthors
     */
    public function setAuthorRelation(int $bookId, int $authorId): BooksAuthors;
    /**
     * Find or create book-tag relation
     * 
     * @param int $bookId
     * @param int $tagId
     * @return BooksTags
     */
    public function setTagRelation(int $bookId, int $tagId): BooksTags;
    /**
     * Delete author from book's authors list
     * 
     * @param int $bookId
     * @param int $authorId
     * @return bool
     */
    public function deleteAuthorRelation(int $bookId, int $authorId): bool;
    /**
     * Delete tag from book's tags list
     * 
     * @param int $bookId
     * @param int $tagId
     * @return bool
     */
    public function deleteTagRelation(int $bookId, int $tagId): bool;
    /**
     * Delete  from book's tags list
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteAuthorRelations(int $bookId): bool;
    /**
     * Delete all tags from book's tags list
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteTagRelations(int $bookId): bool;
}
