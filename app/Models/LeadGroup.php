<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasOwners;
use EloquentFilter\Filterable;


class LeadGroup extends Model
{
    use HasFactory;
    use HasOwners;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'code', 'open', 'close', 'k_leads', 'max_leads', 'enabled'];

    //**********Casts
    /*protected $casts = [
        'open' => 'datetime:H:i:s',
        'close' => 'datetime:H:i:s',
    ];*/

    //**********Связи
    //Лиды в группе
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
