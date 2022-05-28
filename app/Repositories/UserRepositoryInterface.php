<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\UserDataTransferObject;

/**
 * Repository for User table
 *
 * @     vyacheslav
 */
interface UserRepositoryInterface
{
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
     * @param UserDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch( ?UserDataTransferObject $search, bool $paginate = true, array $columns = ['*']);

    /**
     * Return upadted record if it exists
     *
     * @param int $id
     * @param UserDataTransferObject $userDTO
     * @return User|null
     */
    public function update(int $id, UserDataTransferObject $userDTO): ?User;
    /**
     * Return record if it exists
     *
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User;
    /**
     * Delete record if it exists
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
