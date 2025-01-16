<?php

namespace Database\Seeders;

use App\Constants\RoleConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(RoleConstant $rolesConst): void
    {
        $roles = $rolesConst->getConstants();
        foreach ($roles as $role) {
            Role::create([
                'name'          => $role,
//                'guard_name'    => 'api',
            ]);
        }
    }
}
