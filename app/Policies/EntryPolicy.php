<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entry;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the entry can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list entries');
    }

    /**
     * Determine whether the entry can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function view(User $user, Entry $model)
    {
        return $user->hasPermissionTo('view entries');
    }

    /**
     * Determine whether the entry can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create entries');
    }

    /**
     * Determine whether the entry can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function update(User $user, Entry $model)
    {
        return $user->hasPermissionTo('update entries');
    }

    /**
     * Determine whether the entry can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function delete(User $user, Entry $model)
    {
        return $user->hasPermissionTo('delete entries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete entries');
    }

    /**
     * Determine whether the entry can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function restore(User $user, Entry $model)
    {
        return false;
    }

    /**
     * Determine whether the entry can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Entry  $model
     * @return mixed
     */
    public function forceDelete(User $user, Entry $model)
    {
        return false;
    }
}
