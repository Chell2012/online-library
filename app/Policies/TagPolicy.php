<?php

namespace App\Policies;

use App\Models\Tag;

class TagPolicy extends ResoucePolicy
{
    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return Tag::class;
    }
}
