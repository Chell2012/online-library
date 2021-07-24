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
interface TagRepositoryInterface
{
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection;
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Tag|null
     */
    public function getById(int $id): ?Tag;
    /**
     * Create new record
     * 
     * @param string $title
     * @param int $categoryId
     * @return Tag
     */
    public function new(string $title, int $categoryId = null): Tag;
    /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @param int $categoryId
     * @return Tag|null
     */
    public function update(int $id, string $title, int $categoryId): ?Tag;
    /**
     * Delete record if it exists
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    /**
     * Approve or deapprove published record
     * 
     * @param int $approved
     * @param int $id
     * @return bool
     */
    public function approve(int $approved, int $id): bool;
}
