<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //Администратор
        $admin = new User();
        $admin->name = 'Администратор';
        $admin->email = 'admin@mail.com';
        $admin->password = Hash::make('admin');
        $admin->save();

        //Партнеры
        for ($i=1; $i < 10; $i++) {
            $partner = new User();
            $partner->name = 'Партнер'.$i;
            $partner->email = 'partner'.$i.'@mail.com';
            $partner->password = Hash::make('partner');
            $partner->save();
        }
    }
}
