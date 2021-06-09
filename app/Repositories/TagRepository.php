<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Tag;
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
     * @param type $id
     * @return bool
     */
    public function delete($id): bool
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
