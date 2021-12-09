<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Illuminate\Support\Facades\Config;

class Permission extends LaratrustPermission
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'icon',
        'permission_group_id',
    ];

    /**
     * Связь разрешение имеет одну группу разрешений
     *
     */
    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}
