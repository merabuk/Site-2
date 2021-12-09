<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        if ($user->hasRole('administrator') || $user->hasPermission('menu-show-users') || $user->roles->first()->hasPermission('menu-show-users')) {
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
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
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
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
        // return $user->id === auth()->user()->id;
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
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    /**
     * Определяет, может ли, авторизированный пользователь открепить группу от конкретного пользователя
     */
    public function removeGroupFromUser(User $user, User $model)
    {
        return false;
    }

    /**
     * Определяет, может ли, авторизированный пользователь открепить группы от конкретного пользователя
     */
    public function removeGroupsFromUser(User $user, User $model)
    {
        return false;
    }

    /**
     * Определяет, может ли, авторизированный пользователь прикрепить группу/группы к конкретному пользователю
     */
    public function addGroupsToUser(User $user, User $model)
    {
        return false;
    }

    /**
     * Определяет, может ли, авторизированный пользователь открепить лид от конкретного пользователя
     */
    public function removeLeadFromUser(User $user, User $model)
    {
        return false;
    }

    /**
     * Определяет, может ли, авторизированный пользователь открепить лидов от конкретного пользователя
     */
    public function removeLeadsFromUser(User $user, User $model)
    {
        return false;
    }

    /**
     * Определяет, может ли, авторизированный пользователь прикрепить лид/лиды к конкретному пользователю
     */
    public function addLeadToUser(User $user, User $model)
    {
        return false;
    }
}
