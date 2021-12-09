<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['url', 'method', 'data', 'enabled'];

    //********** Casts **********/
    protected $casts = [
        'data' => 'array',
    ];

    //********** Accessor **********/
    /**
    * Is active webhook exists.
    *
    * @return boolean
    */
    public static function isEnabledWebhookExists()
    {
        return boolval((new static)::where('enabled', true)->count());
    }

}
