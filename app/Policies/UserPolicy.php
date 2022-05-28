<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Return model's name
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(?User $user, User $model = null)
    {
        return ($user->can('view-'.$this->getModelClass()) || ($user->id == $model->id));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return (($user->can('update-'.$this->getModelClass()) && (!$model->hasAnyRole(['Администратор', 'Библиотекарь']))) || ($user->id == $model->id));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if ($user->can('delete-'.$this->getModelClass())){
            if ($model->hasAnyRole(['Администратор', 'Библиотекарь'])){
                return false;
            }
            return true;
        }
        return $user->can('delete-'.$this->getModelClass());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function op(User $user, User $model)
    {
        return $user->can('op-'.$this->getModelClass());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function deop(User $user, User $model)
    {
        return $user->can('deop-'.$this->getModelClass());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function ban(User $user, User $model)
    {
        if ($user->can('ban-'.$this->getModelClass())){
            if ($model->hasAnyRole(['Администратор', 'Библиотекарь'])){
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function unban(User $user, User $model)
    {
        return $user->can('unban-'.$this->getModelClass());
    }
}
