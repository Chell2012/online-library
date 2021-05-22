<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use Illuminate\Support\Collection;

/**
 *
 * @author vyacheslav
 */
interface BookRepositoryInterface {
    /**
     * 
     * @return Collection
     */
    public function all(): Collection;
}
