<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\DTO\TagDataTransferObject;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    public function getAll($columns = ['*']): ?Collection
    {
        return Tag::all($columns);
    }
    /**
     * Return collection of approved records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator
    {
        return Tag::where('approved', '>', '0')->paginate(15)->paginate($perPage = 15, $columns);
    }

    /**
     * Return collection of records based on search
     *
     * @param TagDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(TagDataTransferObject $search = null, bool $paginate = true, array $columns = ['*'])
    {
        if ($search->getApproved()!=null){
            $list = Tag::whereIn('approved', $search->getApproved());
        } else {
            $list = Tag::where('approved', '>', '0');
        }
        if ($search->getTitle()!=null){
            $list = $list->where('title', $search->getTitle());
        }
        if ($search->getCategory()!=null){
            $list = $list->where('category_id', $search->getCategory());
        }
        return ($paginate)? $list->paginate($perPage = 15, $columns): $list->get();
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
    public function new(TagDataTransferObject $tagDTO): ?Tag
    {
        if ($tagDTO->getTitle()==null){
            return null;
        }
        return Tag::query()->create([
            'title' => $tagDTO->getTitle(),
            'category_id' => ($tagDTO->getCategory()!=null) ? $tagDTO->getCategory() : 1
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
     * @param TagDataTransferObject $tagDTO
     * @return Tag|null
     */
    public function update(int $id, TagDataTransferObject $tagDTO): ?Tag
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        if ($tagDTO->getTitle()!=null){
            $record->title = $tagDTO->getTitle();
        }
        if ($tagDTO->getCategory()!=null){
            $record->category_id= $tagDTO->getCategory();
        }
        $record->save();
        return $record;
    }
}
