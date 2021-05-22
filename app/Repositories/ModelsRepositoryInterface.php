<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface BookRepositoryInterface
 * @package App\Repositories\Interfaces
 * @author vyacheslav
 */
interface ModelsRepositoryInterface {
    /**
     * 
     * @param type $key
     * @return Model|null
     */
    public function find($key): ?Model;
    
    /**
     * 
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;
    /**
     * 
     * @return bool
     */
    public function delete(): bool;
    /**
     * 
     * @param string $column
     * @param type $operator
     * @param type $value
     * @param type $boolean
     * @return Model|null
     */
    public function where(string $column, $operator, $value, $boolean): ?Model;
}
