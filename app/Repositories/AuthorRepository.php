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
    
    public function getAll($columns = ['*']): ?Collection {
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
    
    public function deleteAuthor(int $id, array $fullmaster): bool {
        if (!($id||$title)) {
            return false;
        }
        if ($id!=null){
            return $this->getAuthorById($id)->delete();
        }
        if ($title != null){
            return $this->getAuthorByFullName($fullmaster)->delete();
        }
        return false;
    }
    public function newAuthor(array $fullmaster): Author{
        return Author:: query()->create($fullmaster);
    }
}
