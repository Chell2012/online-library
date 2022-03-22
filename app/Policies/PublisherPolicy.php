<?php

namespace App\Policies;

use App\Models\Publisher;

class PublisherPolicy extends ResoucePolicy
{
    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return Publisher::class;
    }
}
