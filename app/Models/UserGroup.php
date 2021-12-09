<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use App\Traits\HasLeads;

class UserGroup extends Model
{
    use LaratrustUserTrait;
    use HasFactory;
    use HasLeads;

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
     * Связь группа пользователей имеет много пользователей
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
