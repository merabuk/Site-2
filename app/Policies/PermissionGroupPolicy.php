<?php

namespace App\Policies;

use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionGroupPolicy
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
        if ($user->hasRole('administrator') || $user->hasPermission('menu-show-permission-groups') || $user->roles->first()->hasPermission('menu-show-permission-groups')) {
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
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function view(User $user, PermissionGroup $permissionGroup)
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
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function update(User $user, PermissionGroup $permissionGroup)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function delete(User $user, PermissionGroup $permissionGroup)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function restore(User $user, PermissionGroup $permissionGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function forceDelete(User $user, PermissionGroup $permissionGroup)
    {
        //
    }
}
