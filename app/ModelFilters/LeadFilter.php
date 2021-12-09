<?php

namespace App\ModelFilters;

use App\Models\Lead;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class LeadFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function utms($codes)
    {
            return $this->where(function ($q) use ($codes) {
                foreach ($codes as $code) {
                    $q->whereNotNull('utms->' . $code);
                }
            });
    }

    public function gets($codes)
    {
            return $this->where(function ($q) use ($codes) {
                foreach ($codes as $code) {
                    $q->whereNotNull('gets->' . $code);
                }
            });
    }

    public function leadStatus($codes)
    {
        if (in_array('Новый', $codes)) {
            // т.к. условия поиска SQl в операторе in не позволяют искать нулевые значения в столбце, то поиск проводим двумя этапами
            // первый по массиву данных, второй по значению 0
            $codes = array_diff($codes, ['Новый']);
            return $this->whereHas('leadStatus', function ($query) use($codes){
                return $query->whereIn('code', $codes);
            })->orWhereNull('lead_status_id');
        } else {
            // если нет необходимости выбирать нулевые значения, выбираем из таблицы все строки с нужными кодами
            return $this->whereHas('leadStatus', function ($query) use ($codes) {
                return $query->whereIn('lead_statuses.code', $codes);
            });
        }
    }

    public function leadGroup($codes)
    {
        if (in_array('WithoutGroup', $codes)) {
            // т.к. условия поиска SQl в операторе in не позволяют искать нулевые значения в столбце, то поиск проводим двумя этапами
            // первый по массиву данных, второй по значению 0
            return $this->whereHas('leadGroup', function ($query) use($codes){
                return $query->whereIn('code', $codes);
            })->orWhereNull('lead_group_id');
        } else {
            return $this->whereHas('leadGroup', function ($query) use ($codes) {
                return $query->whereIn('lead_groups.code', $codes);
            });
        }
    }

    public function dateRange($range)
    {
        // выделяем диапозон дат из строки
        $arr = explode(' ', $range);

        $from = $arr[0];
        $to = $arr[2];
        // преобразовываем полученнуе данные в формат дат приемлимый для sql запроса
        $from = Carbon::parse($from)->startOfDay();
        $to = Carbon::parse($to)->endOfDay();
        return $this->whereBetween('leads.created_at', [$from, $to]);
    }

}
