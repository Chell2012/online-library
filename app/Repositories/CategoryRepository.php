<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\DTO\CategoryDataTransferObject;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * Return collection of approved records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAllApproved(array $columns = ['*']): ?Collection
    {
        return Category::all($columns)->where('approved', '>', '0');
    }

    /**
     * Return collection of records based on search
     *
     * @param CategoryDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(CategoryDataTransferObject $search = null, bool $paginate = true, array $columns = ['*'])
    {
        if ($search->getApproved()!=null){
            $list = Category::whereIn('approved', $search->getApprove());
        } else {
            $list = Category::where('approved', '>', '0');
        }
        if ($search->getTitle()!=null){
            $list = $list->where('title','like', '%'.$search->getTitle().'%');
        }
        return ($paginate)? $list->paginate($perPage = 15, $columns) : $list->get();
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
}
