<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Publisher;
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
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection 
    {
        return Publisher::all($columns);
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
    public function new(string $title): Publisher
    {
        return Publisher::query()->create(['title'=>$title]);
    }
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @return Publisher|null
     */
    public function update(int $id, string $title): ?Publisher
    {
        $publisher = Publisher::query()->find($id);
        $publisher->title = $title;
        $publisher->save();
        return $publisher;
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
