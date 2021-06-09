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
 * Description of PublisherRepository
 *
 * @author vyacheslav
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection
    {
        return Category::all($columns);
    }
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Category|null
     */
    public function getById(int $id): ?Category
    {
        return Category::query()->find($id);
    }
    /**
     * Delete record if it exists
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if ($id!=null){
            return Category::query()->find($id)->delete();
        }
        return false;
    }
    /**
     * Create new record
     * 
     * @param string $title
     * @return Category
     */
    public function new(string $title): Category
    {
        return Category::query()->create(['title'=>$title]);
    }
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @return Category|null
     */
    public function update(int $id, string $title): ?Category
    {
        $category = Category::query()->find($id);
        $category->title = $title;
        $category->save();
        return $category;
    }
}
