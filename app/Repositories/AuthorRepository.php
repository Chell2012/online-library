<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\AuthorDataTransferObject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Repository for Author table
 *
 * @author vyacheslav
 */
class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Return collection of records
     *
     * @param array $columns
     * @return Collection|null
     */
    public function getAll(array $columns = ['*']): ?Collection
    {
        return Author::all($columns);
    }
    /**
     * Return collection of approved records
     *
     * @param array $columns
     * @return LengthAwarePaginator|null
     */
    public function getAllApproved(array $columns = ['*']): ?LengthAwarePaginator
    {
        return Author::where('approved', '>', '0')->paginate($perPage = 15, $columns);
    }

    /**
     * Return collection of records based on search
     *
     * @param AuthorDataTransferObject|null $search
     * @param bool $paginate
     * @param array $columns
     * @return LengthAwarePaginator|Collection
     */
    public function getBySearch(AuthorDataTransferObject $search = null, bool $paginate = true, array $columns = ['*'])
    {
        if ($search->getApprove()!=null){
            $list = Author::whereIn('approved', $search->getApprove());
        } else {
            $list = Author::where('approved', '>', '0');
        }
        if ($search->getName()!=null){
            $list = $list->where('name', $search->getName());
        }
        if ($search->getMiddleName()!=null){
            $list = $list->where('middle_name', $search->getMiddleName());
        }
        if ($search->getSurame()!=null){
            $list = $list->where('surname', 'like', '%'.$search->getSurame().'%');
        }
        if ($search->getBirthDate()!=null){
            $list = $list->where('birth_date', $search->getBirthDate());
        }
        if ($search->getDeathDate()!=null){
            $list = $list->where('death_date', $search->getDeathDate());
        }
        return ($paginate)? $list->paginate($perPage = 15, $columns) : $list->get();
    }
    /**
     * Return record if it exists
     *
     * @param int $id
     * @return Author|null
     */
    public function getById(int $id): ?Author
    {
        return Author::query()->find($id);
    }

    /**
     * Return upadted record if it exists
     *
     * @param int $id
     * @param AuthorDataTransferObject $authorDTO
     * @return Author|null
     */
    public function update(int $id, AuthorDataTransferObject $authorDTO): ?Author
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        if ($authorDTO->getName()!=null) {
            $record->name = $authorDTO->getName();
        }
        if ($authorDTO->getMiddleName()!=null){
            $record->middle_name = $authorDTO->getMiddleName();
        }
        if ($authorDTO->getSurame()!=null) {
            $record->surname = $authorDTO->getSurame();
        }
        if ($authorDTO->getBirthDate()!=null){
            $record->birth_date = $authorDTO->getBirthDate();
        }
        if ($authorDTO->getDeathDate()!=null){
            $record->death_date = $authorDTO->getDeathDate();
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

    /**
     * Create new record
     *
     * @param AuthorDataTransferObject $author
     * @return Author|null
     */
    public function new(AuthorDataTransferObject $author): ?Author
    {
        if ($author->getName()==null || $author->getSurame()==null){
            return null;
        }
        return Author:: query()->create([
            'name'=>$author->getName(),
            'surname'=>$author->getSurame(),
            'middle_name'=>$author->getMiddleName(),
            'birth_date'=>$author->getBirthDate(),
            'death_date'=>$author->getDeathDate()
        ]);
    }
    /**
     * Approve or deapprove published record
     *
     * @param int $approved
     * @param int $id
     * @return bool
     */
    public function approve(int $approved, int $id): bool
    {
        if ($id != null){
            $model = $this->getById($id);
            if ($model!=null){
                $model->approved = $approved;
                return $model->save();
            }
        }
        return false;
    }
}
