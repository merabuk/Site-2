<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;
use EloquentFilter\Filterable;


class LeadStatus extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'code', 'color'];

    //**********Связи
    //Лиды статуса
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

}
