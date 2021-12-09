<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Traits\HasLeads;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;
    use HasLeads;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Связь пользователь имеет много групп пользователей
     *
     */
    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class);
    }

    /**
     * Ссылка на профиль пользователя для User Menu AdminLTE 3
     *
     */
    public function adminlte_profile_url()
    {
        return route('users.edit', auth()->user()->id);
    }
}
