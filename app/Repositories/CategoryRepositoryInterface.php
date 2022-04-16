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
 *
 * @author vyacheslav
 */
interface CategoryRepositoryInterface
{
    /**
     * Return collection of records
     *
     * @param mixed|array $columns
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection;
    /**
     * Return collection of approved records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAllApproved(array $columns = ['*']): ?Collection;

    /**
     * Return collection of records based on search
     *
     * @param CategoryDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(CategoryDataTransferObject $search = null, bool $paginate = false, array $columns = ['*']);
    /**
     * Return record if it exists
     *
     * @param int $id
     * @return Category|null
     */
    public function getById(int $id): ?Category;
    /**
     * Create new record
     *
     * @param string $title
     * @return Category
     */
    public function new(string $title): Category;
    /**
     * Update record if it exists
     *
     * @param int $id
     * @param string $title
     * @return Category|null
     */
    public function update(int $id, string $title): ?Category;
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
