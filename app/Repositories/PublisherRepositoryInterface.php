<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Publisher;
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
     * @return Collection|null
     */
    public function getAll($columns = ['*']): ?Collection;
    /**
     * Return record if it exists
     * 
     * @param int $id
     * @return Publisher|null
     */
    public function getById(int $id): ?Publisher;
    /**
     * 
     * @param string $title
     * @return Publisher
     */
    public function new(string $title): Publisher;
     /**
     * Update record if it exists
     * 
     * @param int $id
     * @param string $title
     * @return Publisher|null
     */
    public function update(int $id, string $title): ?Publisher;
    /**
     * Delete record if it exists
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
