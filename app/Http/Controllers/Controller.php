<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Add filter to resource list for policy action
     * 
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'viewOnlyApproved',
            'viewNotApproved' => 'viewAny',
            'show' => 'view',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'approve' => 'approve'
        ];
    }
    /**
     * Add filter to actions without model dependency for policy action
     * 
     * @return array 
     */
    protected function resourceMethodsWithoutModels()
    {
        return ['viewNotApproved', 'index', 'store', 'approve'];
    }
}
