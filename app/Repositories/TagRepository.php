<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of PublisherRepository
 *
 * @author vyacheslav
 */
class TagRepository implements TagRepositoryInterface
{
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Paginator
    {
        return Tag::paginate(15);
    }
    /**
     * Return collection of approved records
     * 
     * @param array $columns
     * @return Collection|null
     */
    public function getAllApproved(array $columns = ['*']): ?Paginator
    {
        return Tag::where('approved', '>', '0')->paginate(15);
    }
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Tag|null
     */
    public function getById(int $id): ?Tag
    {
        return Tag::query()->find($id);
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
     * @param int $categoryId
     * @return Tag
     */
    public function new(string $title, int $categoryId = null): Tag
    {
        if ($categoryId === null){
            $categoryId = 1;
        }
        return Tag::query()->create([
            'title' => $title,
            'category_id' => $categoryId
        ]);
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
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @param int $categoryId
     * @return Tag|null
     */
    public function update(int $id, string $title, int $categoryId): ?Tag
    {   
        $tag = Tag::query()->find($id);
        $tag->category_id = $categoryId;
        $tag->title = $title;
        $tag->save();
        return $tag;
    }
}
