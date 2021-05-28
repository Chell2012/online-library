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
    public function getBookById(int $id): ?array{
        $book = Book::query()->find($id);
        $authors = $this->getBookAuthors($id);
        $tags = $this->getBookTags($id);
        return isset($book)?[
            'book'=>$book,
            'authors'=>$authors,
            'tags'=>$tags
        ]:null;
    }
    
    /**
     * 
     * @param int $bookId
     * @return Collection
     */
    public function getBookAuthors(int $bookId): Collection {
        return BooksAuthors::query()->where('book_id', $bookId)->get();
    }
    /**
     * 
     * @param int $bookId
     * @return Collection
     */
    public function getBookTags(int $bookId): Collection {
        return BooksTags::query()->where('book_id', $bookId)->get();
    }
    
    /**
     * 
     * @param int $bookId
     * @param int $authorId
     * @return BooksAuthors
     */
    public function setBookAuthor(int $bookId, int $authorId): BooksAuthors{
        return BooksAuthors::query()->create([
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
        return BooksTags::query()->create([
            'book_id'=>$bookId,
            'tag_id'=>$tagId
        ]);
    }
}
