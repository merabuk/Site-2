<?php

namespace App\Policies;

use App\Models\GetParam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GetParamPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('administrator') || $user->hasPermission('menu-show-get-params') || $user->roles->first()->hasPermission('menu-show-get-params')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GetParam  $getParam
     * @return mixed
     */
    public function view(User $user, GetParam $getParam)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GetParam  $getParam
     * @return mixed
     */
    public function update(User $user, GetParam $getParam)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GetParam  $getParam
     * @return mixed
     */
    public function delete(User $user, GetParam $getParam)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GetParam  $getParam
     * @return mixed
     */
    public function restore(User $user, GetParam $getParam)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GetParam  $getParam
     * @return mixed
     */
    public function forceDelete(User $user, GetParam $getParam)
    {
        //
    }
}
