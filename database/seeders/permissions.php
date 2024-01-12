<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ["name" => "CREATE_USER", "guard_name" => "api"],
            ["name" => "READ_USER", "guard_name" => "api"],
            ["name" => "UPDATE_USER", "guard_name" => "api"],
            ["name" => "DELETE_USER", "guard_name" => "api"],

            ["name" => "CREATE_ROL", "guard_name" => "api"],
            ["name" => "READ_ROL", "guard_name" => "api"],
            ["name" => "UPDATE_ROL", "guard_name" => "api"],
            ["name" => "DELETE_ROL", "guard_name" => "api"],

            ["name" => "VENDER_PRODUCTO", "guard_name" => "api"],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
