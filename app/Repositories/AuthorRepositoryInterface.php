<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\AuthorDataTransferObject;

/**
 * Repository for Author table
 *
 * @author vyacheslav
 */
interface AuthorRepositoryInterface
{
    /**
     * Return collection of approved records
     *
     * @param array $columns
     * @return LengthAwarePaginator|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator;
    /**
    * Return collection of records
    *
    * @param array $columns
    * @return Collection|null
    */
   public function getAll(array $columns = ['*']): ?Collection;

    /**
     * Return collection of records based on search
     *
     * @param AuthorDataTransferObject|null $search
     * @param array $columns
     * @return ?LengthAwarePaginator|null
     */
    public function getBySearch( ?AuthorDataTransferObject $search, array $columns = ['*']): ?LengthAwarePaginator;
    /**
     * Return upadted record if it exists
     *
     * @param int $id
     * @param AuthorDataTransferObject $author
     * @return Author|null
     */
    public function update(int $id, AuthorDataTransferObject $author): ?Author;
    /**
     * Return record if it exists
     *
     * @param int $id
     * @return Author|null
     */
    public function getById(int $id): ?Author;
    /**
     * Create new record
     *
     * @param AuthorDataTransferObject $author
     * @return Author
     */
    public function new(AuthorDataTransferObject $author): Author;
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
