<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author vyacheslav
 */
interface CategoryRepositoryInterface {
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns): ?Collection;
    /**
     * 
     * @param string $title
     * @return Category|null
     */
    public function getCategoryByTitle(string $title): ?Category;
    /**
     * 
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category;
    /**
     * 
     * @param string $title
     * @return Category
     */
    public function newCategory(string $title): Category;
    /**
     * 
     * @param int $id
     * @param string $title
     * @return bool
     */
    public function deleteCategory(int $id, string $title): bool;
}
