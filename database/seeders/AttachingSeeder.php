<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class AttachingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminGroupId = UserGroup::where('name', 'administratory')->pluck('id');
        $roleAdmin = Role::where('name', 'administrator')->first();

        $partnerGroupId = UserGroup::where('name', 'partnery1')->pluck('id');
        $rolePartner = Role::where('name', 'partner')->first();

        // $permissions = Permission::all();

        //Для администратора
        $admin = User::find(1);
        $admin->attachRole($roleAdmin);
        $admin->userGroups()->attach($adminGroupId);

        //Для партнеров
        $partners = User::whereNotIn('id', ['1'])->get();
        foreach ($partners as $key => $partner) {
            $partner->attachRole($rolePartner);
            if ($partner->id <= 9) {
                $partner->userGroups()->attach($partnerGroupId);
            }
        }


    }
}
