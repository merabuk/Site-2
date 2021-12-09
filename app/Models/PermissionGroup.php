<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'icon',
    ];

    /**
     * Связь группа разрешений имеет много разрешений
     *
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
