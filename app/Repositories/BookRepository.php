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
use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Description of BookRepository
 *
 * @author vyacheslav
 */
class BookRepository extends ModelRepository implements BookRepositoryInterface{
        
    /**
     * 
     * @param Book $model
     */
    public function __construct(Book $model) {
        parent::__construct($model);
    }
    /**
     * 
     * @return Collection
     */
    public function all(): Collection {
        return $this->model->all();
    }
    /**
     * 
     * @param int $bookId
     * @return Collection
     */
    public function getAuthors(int $bookId): Collection {
        return $this->model->authors()->where('book_id', $bookId);
    }
    
    public function getTags(int $bookId): Collection {
        return $this->model->tags()->where('book_id', $bookId);
    }
    
    public function setAuthor(int $bookId, int $authorId): Model{
        return $this->model->authors()->create([
            'book_id'=>$bookId,
            'author_id'=>$authorId
        ]);
    }
}
