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
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return  LengthAwarePaginator|null
     */
    public function getAll($columns = ['*']): ?LengthAwarePaginator
    {
        return Book::all()->paginate($perPage = 15, $columns);
    }

    /**
     * Return collection of books after filter
     * 
     * @param FilterDataTransferObject $filter
     * @param bool $paginate
     * @param array $columns
     * @return Collection|LengthAwarePaginator
     */
    public function getBySearch(FilterDataTransferObject $filter, bool $paginate = true, array $columns = ['*'])
    {
        if ($filter->getApproved()!=null){
            $query = Book::whereIn('approved', $filter->getApproved());
        } else {
            $query = Book::where('approved', '>', '0');
        }
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
            $query->where('title', 'like', '%'.$filter->getTitle().'%');
        }
        if($filter->getYear()!=null){
            $query->where('year', '=', $filter->getYear());
        }
        if($filter->getSortBy()!=null){
            $query->orderBy($filter->getSortBy);
        }
        return ($paginate)?
            $query->with('tags')->with('authors')->paginate($perPage = 15, $columns):
            $query->with('tags')->with('authors')->get($columns);
    }

    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Book|null
     */
    public function getById(int $id): ?Book
    {
        return Book::query()->find($id);
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
        if ($BookDTO->getTitle()==null){
            return null;
        }
        return Book::query()->create([
            'title'=>$BookDTO->getTitle(),
            'publisher_id'=>($BookDTO->getPublisherId())?($BookDTO->getPublisherId()):0,
            'year'=>$BookDTO->getYear(),
            'isbn'=>$BookDTO->getISBN(),
            'category_id'=>($BookDTO->getCategoryId())?($BookDTO->getCategoryId()):0,
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
        $book = $this->getById($id);
        if (!isset($book)){
            return null;
        }
        if ($BookDTO->getTitle()!=null){
            $book->title = $BookDTO->getTitle();
        }
        if ($BookDTO->getPublisherId()!=null){
            $book->publisher_id = $BookDTO->getPublisherId();
        }
        $book->year = $BookDTO->getYear();
        $book->isbn = $BookDTO->getISBN();
        if ($BookDTO->getCategoryId()!=null){
            $book->category_id = $BookDTO->getCategoryId();
        }
        $book->user_id = $userId;
        if ($BookDTO->getLink()!=null){
            $book->link = $BookDTO->getLink();
        }
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
        if ($id!=null){
            return $this->getById($id)->delete();
        }
        return false;
    }

    /**
     * Return Collection of book authors
     * 
     * @param int $bookId
     * @param bool $fullNames
     * @return Collection
     */
    public function getAuthorRelations(int $bookId): ?Collection
    {
        return BooksAuthors::query()->where('book_id', $bookId)->with('author')->get();
    }

    /**
     * Return Collection of book tags
     * 
     * @param int $bookId
     * @param bool $fullTitle
     * @return Collection
     */
    public function getTagRelations(int $bookId): ?Collection
    {
        return BooksTags::query()->where('book_id', $bookId)->with('tag')->get();
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