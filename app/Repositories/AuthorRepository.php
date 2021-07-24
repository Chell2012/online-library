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
     * @param array $author
     * @return Author|null
     */
    public function update(int $id, AuthorDataTransferObject $author): ?Author
    {
        $record = $this->getById($id);
        if ($record === null){
            return null;
        }
        $record->name = $author->getName();
        if ($author->getMiddleName()!=null){
            $record->middle_name = $author->getMiddleName();
        }
        $record->surname = $author->getSurame();
        if ($author->getMiddleName()!=null){
            $record->birth_date = $author->getBirthDate();
        }
        if ($author->getMiddleName()!=null){
            $record->death_date = $author->getDeathDate();
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
     * @param array $author
     * @return Author
     */
    public function new(AuthorDataTransferObject $author): Author
    {
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