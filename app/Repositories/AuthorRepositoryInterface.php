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
 *
 * @author vyacheslav
 */
interface AuthorRepositoryInterface {
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection;

    /**
     * 
     * @param array $fullmaster author's 'surname', 'middle_name' and 'name'
     * @return Author|null
     */
    public function getAuthorByFullName(array $fullmaster): ?Author;
    /**
     * 
     * @param int $id
     * @return Author|null
     */
    public function getAuthorById(int $id): ?Author;
    /**
     * 
     * @param array $fullmaster author's 'surname', 'middle_name' and 'name'
     * @return Author
     */
    public function newAuthor(array $fullmaster): Author;
    /**
     * 
     * @param int $id
     * @param array $fullmaster
     * @return bool
     */
    public function deleteAuthor(int $id, array $fullmaster): bool;
}
