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
use App\DTO\BookDataTransferObject;
use App\DTO\FilterDataTransferObject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Repository of book table
 *
 * @author vyacheslav
 */
class BookRepository implements BookRepositoryInterface
{   
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return Collection|null
     */
    public function getAllApproved($columns = ['*']): ?Collection
    {
        return Book::all($columns)->where('approved', '>', '0');;
    }
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection
    {
        return Book::all($columns);
    }
    /**
     * Return collection of books after filter
     * 
     * @param FilterDataTransferObject $filter
     * @return Collection|null
     */
    public function getByFilter(FilterDataTransferObject $filter): ?Collection
    {
        $query = Book::query();
        if($filter->getAuthorsIds()!=null){
            foreach($filter->getAuthorsIds() as $authorId){
                $query->whereHas('authors',function(Builder $authorQuery) use ($authorId){
                    return $authorQuery->where('author_id', $authorId);
                });
            }
        }
        if($filter->getTagsIds()!=null){
            foreach($filter->getTagsIds() as $tagId){
                $query->whereHas('tags',function(Builder $tagQuery) use ($tagId){
                    return $tagQuery->where('tag_id', $tagId);
                });
            }
        }
        if($filter->getCategoryId()!=null){
            $query->where('category_id', '=', $filter->getCategoryId());
        }
        if($filter->getISBN()!=null){
            $query->where('isbn', '=', $filter->getISBN());
        }
        if($filter->getPublisherId()!=null){
            $query->where('publisher_id', '=', $filter->getPublisherId());
        }
        if($filter->getTitle()!=null){
            $query->where('title', '=', $filter->getTitle());
        }
        if($filter->getYear()!=null){
            $query->where('year', '=', $filter->getYear());
        }
        return $query->with('tags')->with('authors')->get();
    }
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?Book
    {
        return Book::query()->find($id);
    }
    /**
     * Return book with tags and authors
     * 
     * @param int $id
     * @return array|null
     */
    public function getWithRelations(int $id): ?array
    {
        $book = $this->getById($id);
        $authors = $this->getAuthorRelations($id, true);
        $tags = $this->getTagRelations($id, true);
        return isset($book)?[
            'book'=>$book,
            'authors'=>$authors,
            'tags'=>$tags
        ]:null;
    }
    /**
     * Create new record
     * 
     * @param int $userId
     * @param BookDataTransferObject $BookDTO
     * @return Book|null
     */
    public function new(int $userId, BookDataTransferObject $BookDTO): ?Book
    {
        return Book::query()->create([
            'title'=>$BookDTO->getTitle(),
            'publisher_id'=>$BookDTO->getPublisherId(),
            'year'=>$BookDTO->getYear(),
            'isbn'=>$BookDTO->getISBN(),
            'category_id'=>$BookDTO->getCategoryId(),
            'user_id'=>$userId,
            'link'=>$BookDTO->getLink(),
            'description'=>$BookDTO->getDescription()
        ]);
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
        if ($id != null){
            $model = $this->getById($id);
            if ($model!=null){
                $model->approved = $approved;
                return $model->save();
            }
        }
        return false; 
    }
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param int $userId
     * @param BookDataTransferObject $BookDTO
     * @return Book|null
     */
    public function update(int $id, int $userId, BookDataTransferObject $BookDTO): ?Book
    {
        $book = Book::query()->find($id);
        if (!isset($book)){
            return null;
        }
        $book->title = $BookDTO->getTitle();
        $book->publisher_id = $BookDTO->getPublisherId();
        $book->year = $BookDTO->getYear();
        $book->isbn = $BookDTO->getISBN();
        $book->category_id = $BookDTO->getCategoryId();
        $book->user_id = $userId;
        $book->link = $BookDTO->getLink();
        $book->description = $BookDTO->getDescription();
        $book->save();
        return $book;
    }
    /**
     * Delete book with that id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $removingBook = $this->getById($id);
        if ($removingBook!=null){
            return $removingBook->delete();
        }
        return false;
    }
    /**
     * Return Collection of book authors
     * 
     * @param int $bookId
     * @param bool $fullNames true - return authors with 'author' db record
     * @return Collection
     */
    public function getAuthorRelations(int $bookId, bool $fullNames = false): ?Collection
    {
        if ($fullNames) {
            return BooksAuthors::query()->where('book_id', $bookId)->with('author')->get();
            
        }
        return BooksAuthors::query()->where('book_id', $bookId)->get();
    }
    /**
     * Return Collection of book tags
     * 
     * @param int $bookId
     * @param bool $fullTitle
     * @return Collection
     */
    public function getTagRelations(int $bookId, bool $fullTitle = false): ?Collection
    {
        if($fullTitle){
            return BooksTags::query()->where('book_id', $bookId)->with('tag')->get();
        }
        return BooksTags::query()->where('book_id', $bookId)->get();
    }
    /**
     * Find or create book-author relation
     * 
     * @param int $bookId
     * @param int $authorId
     * @return BooksAuthors
     */
    public function setAuthorRelation(int $bookId, int $authorId): BooksAuthors
    {
        return BooksAuthors::query()->firstOrCreate([
            'book_id'=>$bookId,
            'author_id'=>$authorId
        ]);
    }
    /**
     * Find or create book-tag relation
     * 
     * @param int $bookId
     * @param int $tagId
     * @return BooksTags
     */
    public function setTagRelation(int $bookId, int $tagId): BooksTags
    {
        return BooksTags::query()->firstOrCreate([
            'book_id'=>$bookId,
            'tag_id'=>$tagId
        ]);
    }
    /**
     * Delete author from book's authors list
     * 
     * @param int $bookId
     * @param int $authorId
     * @return bool
     */
    public function deleteAuthorRelation(int $bookId, int $authorId): bool 
    {
        return BooksAuthors::query()->where('book_id', $bookId)->where('author_id', $authorId)->delete();
    }
    /**
     * Delete tag from book's tags list
     * 
     * @param int $bookId
     * @param int $tagId
     * @return bool
     */
    public function deleteTagRelation(int $bookId, int $tagId): bool 
    {
        return BooksTags::query()->where('book_id', $bookId)->where('tag_id', $tagId)->delete();
    }
    /**
     * Delete authors from book's authors list
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteAuthorRelations(int $bookId): bool
    {
        return BooksAuthors::query()->where('book_id', $bookId)->delete();
    }
    /**
     * Delete all tags from book's tags list
     * 
     * @param int $bookId
     * @return bool
     */
    public function deleteTagRelations(int $bookId): bool
    {
        return BooksTags::query()->where('book_id', $bookId)->delete();
    }
}