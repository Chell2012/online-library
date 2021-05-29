<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of PublisherRepository
 *
 * @author vyacheslav
 */
class AuthorRepository implements AuthorRepositoryInterface {
    
    public function getAll(array $columns = ['*']): ?Collection {
        return Author::all($columns);
    }
    
    public function getAuthorById(int $id): ?Author {
        return Author::query()->find($id);
    }
    
    public function getAuthorByFullName(array $fullmaster): ?Author{
        return Author::query()
                ->where('surname', $fullmaster["surname"])
                ->where('middle_name', isset($fullmaster["middle_name"])?
                    $fullmaster["middle_name"]:null)
                ->where('name', $fullmaster["name"])
                ->first();
    }
    /**
     * 
     * @param int $id
     * @param array $fullmaster
     * @return Author|null
     */
    public function updateAuthor(int $id, array $fullmaster): ?Author {
        $author = $this->getAuthorById($id);
        if (isset($fullmaster['name'])) {$author->name = $fullmaster['name'];}
        if (isset($fullmaster['middle_name'])) {$author->middle_name = $fullmaster['middle_name'];}
        if (isset($fullmaster['surname'])) {$author->surname = $fullmaster['surname'];}
        $author ->save();
        return $author;
    }
    public function getAuthorId(array $fullmaster): int {
        
        $author = $this->getAuthorByFullName($fullmaster);
        
        if ($author===NULL){
            $author = $this->newAuthor($fullmaster);
        }

        return $author->id;
    }
    
    public function deleteAuthor(int $id): bool {
        if ($id!=null){
            return $this->getAuthorById($id)->delete();
        }
        return false;
    }
    
    public function newAuthor(array $fullmaster): Author{
        return Author:: query()->create($fullmaster);
    }
}
