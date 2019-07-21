<?php

namespace App\Policies;

use App\User;
use App\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any books.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the book.
     *
     * @param  \App\User  $user
     * @param  \App\=Book  $=Book
     * @return mixed
     */
    public function view(User $user, Book $Book)
    {
        //
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $Book
     * @return mixed
     */
    public function update(User $user, Book $Book)
    {
        return $user->id === $Book->currentOwner_id;
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $Book
     * @return mixed
     */
    public function delete(User $user, Book $Book)
    {
        return $user->id === $Book->currentOwner_id;
    }

    /**
     * Determine whether the user can trade the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $Book
     * @return mixed
     */
    public function trade(User $user, Book $Book)
    {
        return $user->id === $Book->currentOwner_id;
    }


    /**
     * Determine whether the user can restore the book.
     *
     * @param  \App\User  $user
     * @param  \App\=Book  $=Book
     * @return mixed
     */
    public function restore(User $user, Book $Book)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the book.
     *
     * @param  \App\User  $user
     * @param  \App\=Book  $Book
     * @return mixed
     */
    public function forceDelete(User $user, Book $Book)
    {
        //
    }
}
