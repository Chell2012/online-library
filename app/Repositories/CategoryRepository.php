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
     * @return LengthAwarePaginator|null
     */
    public function getAll($columns = ['*']): ?LengthAwarePaginator
    {
        return Category::all()->paginate($perPage = 15, $columns);
    }

    /**
     * Return collection of approved records
     *
     * @param array $columns
     * @return LengthAwarePaginator|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator
    {
        return Category::where('approved', '>', '0')->paginate($perPage = 15, $columns);
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
            $list = Category::whereIn('approved', $search->getApproved());
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
            return $this->getById($id)->delete();
        }
        return false;
    }

    /**
     * Create new record
     *
     * @param string $title
     * @return Category|null
     */
    public function new(CategoryDataTransferObject $categoryDTO): ?Category
    {
        if ($categoryDTO->getTitle()==null){
            return null;
        }
        return Category::query()->create(['title'=>$categoryDTO->getTitle()]);
    }

    /**
     * Update record if it exists
     *
     * @param int $id
     * @param string $title
     * @return Category|null
     */
    public function update(int $id, CategoryDataTransferObject $categoryDTO): ?Category
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        if ($categoryDTO->getTitle()!=null){
            $record->title = $categoryDTO->getTitle();
        }
        $record->save();
        return $record;
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