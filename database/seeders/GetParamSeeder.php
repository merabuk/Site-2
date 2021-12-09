<?php

namespace Database\Seeders;

use App\Models\GetParam;
use Illuminate\Database\Seeder;

class GetParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Стандартные гет параметры отображаемые в лиде (карточке лида)
        //Покупатель
        $get = new GetParam();
        $get->name = 'Покупатель';
        $get->code = 'buyer';
        $get->order = 1;
        $get->save();

        //Телефон
        $get = new GetParam();
        $get->name = 'Телефон';
        $get->code = 'phone';
        $get->order = 2;
        $get->save();

        //Email
        $get = new GetParam();
        $get->name = 'Email';
        $get->code = 'email';
        $get->order = 3;
        $get->save();

        //Товар
        $get = new GetParam();
        $get->name = 'Товар';
        $get->code = 'product';
        $get->order = 4;
        $get->save();

        //Цена
        $get = new GetParam();
        $get->name = 'Цена';
        $get->code = 'price';
        $get->order = 5;
        $get->save();
    }
}
