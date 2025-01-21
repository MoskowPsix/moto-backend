<?php

namespace Database\Seeders;

use App\Constants\RoleConstant;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(RoleConstant $roleConst): void
    {
        $users = User::factory()->create([
            'name' => 'root',
            'email' => 'bolshe.kivi@gmail.com',
            'password' => bcrypt(env('ROOT_PASSWD')),
        ])->assignRole($roleConst->getConstants()['ROOT']);

        $users->each(function($user) {
            PersonalInfo::factory()->create(['user_id' => $user->id]);
        });
    }
}
