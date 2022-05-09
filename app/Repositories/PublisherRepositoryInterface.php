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
 *
 * @author vyacheslav
 */
interface PublisherRepositoryInterface {
    /**
     * Return collection of records
     * 
     * @param array|mixed $columns
     * @return LengthAwarePaginator|null
     */
    public function getAll($columns = ['*']): ?LengthAwarePaginator;
    /**
     * Return collection of approved records
     * 
     * @param array $columns
     * @return LengthAwarePaginator|null
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
    public function getBySearch(PublisherDataTransferObject $search = null, bool $paginate = true, array $columns = ['*']);
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Publisher|null
     */
    public function getById(int $id): ?Publisher;
    /**
     * 
     * @param PublisherDataTransferObject $publisherDTO
     * @return Publisher|null
     */
    public function new(PublisherDataTransferObject $publisherDTO): ?Publisher;
     /**
     * Update record if it exists
     * 
     * @param int $id
     * @param PublisherDataTransferObject $publisherDTO
     * @return Publisher|null
     */
    public function update(int $id, PublisherDataTransferObject $publisherDTO): ?Publisher;
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
