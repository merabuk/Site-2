<?php

namespace App\Traits;

use App\Models\User;
use App\Models\UserGroup;

trait HasOwners
{
    /**
     * Many-to-Many relations with User.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'owner', 'leads_owns', 'lead_id', 'owner_id');
    }

    /**
     * Many-to-Many relations with UserGroup.
     */
    public function userGroups()
    {
        return $this->morphedByMany(UserGroup::class, 'owner', 'lead_groups_owns', 'lead_group_id', 'owner_id');
    }
}
