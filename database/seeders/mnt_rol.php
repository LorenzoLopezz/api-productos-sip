<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class mnt_rol extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'SUPER_ADMIN', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_PERFIL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_PERFIL_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_PERFIL_EDIT', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_RUTA_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_RUTA_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_RUTA_EDIT', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_USER_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_USER_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_USER_EDIT', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_ROLE_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_ROLE_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_PERFIL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_ROLE_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_ROLE_EDIT', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_RUTA_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_USER_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ADMIN_USER_VIEW', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_SUPER_ADMIN', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_UPDATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_ROL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_PERFIL_ROL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ROL_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ROL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ROL_UPDATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_ROL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_ROL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_UPDATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_RUTA_ROL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_METHOD_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_PERFIL_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_PERFIL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_ROL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_UPDATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_CREATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_PERFIL_LIST', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_PASSWORD_UPDATE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],
            ['name' => 'ROLE_USER_EMAIL_DELETE', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')],


            ['name' => 'ROLE_VENDEDOR', 'guard_name' => 'api', 'created_at' => Carbon::now()->tz('America/El_Salvador')]
        ];
        DB::table('roles')->insert($roles);
    }
}
