<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeadGroup;
use App\Models\LeadStatus;
use App\Traits\HasOwners;
use EloquentFilter\Filterable;

class Lead extends Model
{
    use HasFactory;
    use HasOwners;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['gets', 'utms'];


    //**********Casts
    protected $casts = [
        'gets' => 'collection',
        'utms' => 'collection',
    ];

    //**********Связи
    //К какой группе принадлежит лид
    public function leadGroup()
    {
        return $this->belongsTo(LeadGroup::class);
    }

    //Статус лида
    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class);
    }

    //**********Scoupes

    /**
     * Фильтр лидов по группам + все/новые
     */
    public function scopeForGroup($query, $leadGroupCode = null)
    {
        switch ($leadGroupCode) {
            //Все посты
            case null:
            case 'all':
                return $query;
                break;
            //Новые посты
            case 'new':
                return $query->whereNull('lead_group_id')->whereNull('lead_status_id');
                break;
            //В иных случаях
            default:
                $leadGroup = LeadGroup::where('code', $leadGroupCode)->firstOrFail();
                return $query->where('lead_group_id', $leadGroup->id);
                break;
        };
    }

}
