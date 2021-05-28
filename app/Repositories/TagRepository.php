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
class TagRepository implements TagRepositoryInterface {
    
    public function getAll($columns = ['*']): ?Collection {
        return Tag::all($columns);
    }
    
    public function getTagById(int $id): ?Tag {
        return Tag::query()->find($id);
    }
    
    public function getTagByTitle(string $title): ?Tag{
        return Tag::query()->where('title',$title)->first();
    }
    
    public function deleteTag($id = null, $title = null): bool {
        if (!($id||$title)) {
            return false;
        }
        if ($id!=null){
            return $this->getTagById($id)->delete();
        }
        if ($title != null){
            return $this->getTagByTitle($title)->delete();
        }
        return false;
    }
    
    public function newTag(array $tagParams): Tag{
        if (!isset($tagParams["category"])){
            $tagParams["category"]=1;
        }
        return Tag::query()->create($tagParams);
    }
}
