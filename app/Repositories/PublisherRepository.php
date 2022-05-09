<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\DTO\PublisherDataTransferObject;
use App\Models\Publisher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of PublisherRepository
 *
 * @author vyacheslav
 */
class PublisherRepository implements PublisherRepositoryInterface 
{
    /**
     * Return collection of records
     * 
     * @param type $columns
     * @return LengthAwarePaginator|null
     */
    public function getAll($columns = ['*']): ?LengthAwarePaginator
    {
        return Publisher::all()->paginate($perPage = 15, $columns);
    }
    /**
     * Return collection of approved records
     * 
     * @param array $columns
     * @return LengthAwarePaginator|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator
    {
        return Publisher::where('approved', '>', '0')->paginate($perPage = 15, $columns);
    }
    /**
     * Return collection of records based on search
     *
     * @param CategoryDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(PublisherDataTransferObject $search = null, bool $paginate = true, array $columns = ['*'])
    {
        if ($search->getApproved()!=null){
            $list = Publisher::whereIn('approved', $search->getApproved());
        } else {
            $list = Publisher::where('approved', '>', '0');
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
     * @return Publisher|null
     */
    public function getById(int $id): ?Publisher
    {
        return Publisher::query()->find($id);
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
     * @return Publisher
     */
    public function new(PublisherDataTransferObject $publisherDTO): ?Publisher
    {
        if ($publisherDTO->getTitle()==null){
            return null;
        }
        return Publisher::query()->create(['title'=>$publisherDTO->getTitle()]);
    }
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @return Publisher|null
     */
    public function update(int $id, PublisherDataTransferObject $publisherDTO): ?Publisher
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        if ($publisherDTO->getTitle()!=null){
            $record->title = $publisherDTO->getTitle();
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
