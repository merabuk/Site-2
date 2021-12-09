<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'uuid'];

    //***** Static functions *****

    /**
     * Поиск токена для API запросов
     *
     */
    public static function isTokenExists($token)
    {
        //Поиск токена
        return (new static)::where('uuid', $token)->exists();
    }

}
