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
 *
 * @author vyacheslav
 */
interface TagRepositoryInterface {
    /**
     * 
     * @param type $columns
     * @return Collection|null
     */
    public function getAll($columns): ?Collection;
    /**
     * 
     * @param string $title
     * @return Tag|null
     */
    public function getTagByTitle(string $title): ?Tag;
    
    /**
     * 
     * @param string $tagTitle
     * @return int
     */
    public function getTagId(string $tagTitle): int; 
    
    /**
     * 
     * @param int $id
     * @return Tag|null
     */
    public function getTagById(int $id): ?Tag;
    /**
     * 
     * @param array $tagParams
     * @return Tag|null
     */
    public function newTag(array $tagParams): Tag;
    /**
     * 
     * @param int $id
     * @param string $title
     * @return bool
     */
    public function deleteTag(int $id, string $title): bool;
}
