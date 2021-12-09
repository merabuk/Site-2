<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Token;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First token
        $token = new Token();
        $token->name = 'First token';
        $token->uuid = 'wZDTnjjpuV3DaTwyoVyQXANogJqzdPIIwJkuihs6W76';
        $token->save();
    }
}
