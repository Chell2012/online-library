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
class CategoryRepository implements CategoryRepositoryInterface {
    
    public function getAll($columns = ['*']): ?Collection {
        return Category::all($columns);
    }
    
    public function getCategoryById(int $id): ?Category {
        return Category::query()->find($id);
    }
    
    public function getCategoryByTitle(string $title): ?Category{
        return Category::query()->where('title',$title)->first();
    }
    
    public function deleteCategory($id = null, $title = null): bool {
        if (!($id||$title)) {
            return false;
        }
        if ($id!=null){
            return Category::query()->find($id)->delete();
        }
        if ($title != null){
            return Category::query()->where('title',$title)->first()->delete();
        }
        return false;
    }
    public function newCategory(string $title): Category{
        return Category:: query()->create(['title'=>$title]);
    }
}
