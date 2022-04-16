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
use Illuminate\Contracts\Pagination\Paginator;
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
     * Return collection of approved records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator;

    /**
     * Return collection of records based on search
     *
     * @param TagDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(TagDataTransferObject $search = null, bool $paginate = true, array $columns = ['*']);
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
     * @param TagDataTransferObject $tagDTO
     * @return Tag
     */
    public function new(TagDataTransferObject $tagDTO): ?Tag;

    /**
     * Update record if it exists
     *
     * @param int $id
     * @param TagDataTransferObject $tagDTO
     * @return Tag|null
     */
    public function update(int $id, TagDataTransferObject $tagDTO): ?Tag;
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
