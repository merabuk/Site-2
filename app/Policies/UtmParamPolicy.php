<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtmParam;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtmParamPolicy
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
        if ($user->hasRole('administrator') || $user->hasPermission('menu-show-utm-params') || $user->roles->first()->hasPermission('menu-show-utm-params')) {
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
     * @param  \App\Models\UtmParam  $utmParam
     * @return mixed
     */
    public function view(User $user, UtmParam $utmParam)
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
     * @param  \App\Models\UtmParam  $utmParam
     * @return mixed
     */
    public function update(User $user, UtmParam $utmParam)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UtmParam  $utmParam
     * @return mixed
     */
    public function delete(User $user, UtmParam $utmParam)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UtmParam  $utmParam
     * @return mixed
     */
    public function restore(User $user, UtmParam $utmParam)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UtmParam  $utmParam
     * @return mixed
     */
    public function forceDelete(User $user, UtmParam $utmParam)
    {
        //
    }
}
