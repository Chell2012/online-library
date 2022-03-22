<?php

namespace App\Policies;

use App\Models\Author;

class AuthorPolicy extends ResoucePolicy
{

    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return Author::class;
    }
}
