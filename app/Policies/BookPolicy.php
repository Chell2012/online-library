<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewOnlyApproved(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return ($user->can('view-not-approved-'.$this->getModelClass()));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Book $book
     * @return bool
     */
    public function view(?User $user, Book $book)
    {
        // if ($user->can('view-not-approved-'.$this->getModelClass())){
        //     return true;
        // }
        // if ($book->approved <= 0){
        //     if (($user != null)&&($user->id == $book->user_id)){
        //         return true;
        //     }
        //     return false;
        // }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('create-'.$this->getModelClass());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Book $book
     * @return bool
     */
    public function update(User $user, Book $book)
    {
        if (
            ($user->can('update-'.$this->getModelClass()))
            ||(($book->approved <= 0)&&($user->id == $book->user_id))
        ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Book $book
     * @return bool
     */
    public function delete(User $user, Book $book)
    {
        if (
            ($user->can('delete-'.$this->getModelClass()))
            ||(($book->approved <= 0)&&($user->id == $book->user_id))
        ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Book $book
     * @return bool
     */
    public function approve(User $user)
    {
        return $user->can('approve-'.$this->getModelClass());
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
