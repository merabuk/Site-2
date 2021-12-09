<?php

namespace App\Policies;

use App\Models\LeadStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadStatusPolicy
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
        if ($user->hasRole('administrator') || $user->hasPermission('menu-show-lead-statuses') || $user->roles->first()->hasPermission('menu-show-lead-statuses')) {
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
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return mixed
     */
    public function view(User $user, LeadStatus $leadStatus)
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
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return mixed
     */
    public function update(User $user, LeadStatus $leadStatus)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return mixed
     */
    public function delete(User $user, LeadStatus $leadStatus)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return mixed
     */
    public function restore(User $user, LeadStatus $leadStatus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadStatus  $leadStatus
     * @return mixed
     */
    public function forceDelete(User $user, LeadStatus $leadStatus)
    {
        //
    }

    /**
     * Определяет, может ли, авторизированный пользователь изменить статус лида
     */
    // public function changeLeadStatus(User $user)
    // {
    //     return false;
    // }
}
