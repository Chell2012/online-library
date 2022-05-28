<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\UserDataTransferObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

/**
 * Repository for User table
 *
 * @author vyacheslav
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Return collection of records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAll(array $columns = ['*']): ?Collection
    {
        return User::all($columns);
    }
    /**
     * Return collection of records based on search
     *
     * @param UserDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(UserDataTransferObject $search = null, bool $paginate = true, array $columns = ['*'])
    {
        $list = User::where('name', 'like', '%');
        if ($search->getName()!=null){
            $list = $list->where('name', 'like', '%'.$search->getName().'%');
        }
        if ($search->getEmail()!=null){
            $list = $list->where('email',  'like', '%'.$search->getEmail().'%');
        }
        if ($search->getVerified()!==null){
            $list = $list->where('email_verified_at', $search->getVerified() ? '!=' : '=', null);
        }
        if ($search->getRoles()!=null){
            $list = $list->role($search->getRoles());
        }
        return ($paginate)? $list->paginate($perPage = 15, $columns) : $list->get($columns);
    }
    /**
     * Return record if it exists
     *
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        return User::query()->find($id);
    }

    /**
     * Return upadted record if it exists
     *
     * @param int $id
     * @param UserDataTransferObject $UserDTO
     * @return User|null
     */
    public function update(int $id, UserDataTransferObject $UserDTO): ?User
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        if ($UserDTO->getName()!=null) {
            $record->name = $UserDTO->getName();
        }
        if ($UserDTO->getEmail()!=null){
            $record->email = $UserDTO->getEmail();
        }
        if ($UserDTO->getVerified()!=null) {
            $record->email_verified_at = ($UserDTO->getVerified()===false) ? NULL : $record->email_verified_at;
        }
        $record->save();
        return $record;
    }
    /**
     * Delete record if it exists
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if ($id != null){
            return $this->getById($id)->delete();
        }
        return false;
    }
}
