<?php

namespace App\Policies;

use App\Models\Category;

class CategoryPolicy extends ResoucePolicy
{
    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return Category::class;
    }
}
