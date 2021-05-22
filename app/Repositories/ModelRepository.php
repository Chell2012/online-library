<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Repositories\ModelsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of BaseRepository
 *
 * @author vyacheslav
 */
class ModelRepository implements ModelsRepositoryInterface {
    /**
     *
     * @var Model
     */
    protected $model;
    
    /**
     * 
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    /**
     * 
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model {
        return $this->model->create($attributes);
    }
    /**
     * 
     * @return bool
     */
    public function delete(): bool {
        return $this->model->delete();
    }
    /**
     * 
     * @param type $key
     * @return Model|null
     */
    public function find($key): ?Model {
        return $this->model->find($key);
    }
    
    public function where(string $column, $operator = null, $value = null, $boolean = 'and'): ?Model{
        return $this->model->where($column,$operator,$value,$boolean);
    }
    
}
