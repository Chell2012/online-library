<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy extends ResoucePolicy
{
    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return Book::class;
    }
    /**
     * Determine whether the user can search models.
     *
     * @param  \App\Models\User  $user|null
     * @return mixed
     */
    public function filter(?User $user)
    {
        return true;
    }
}
