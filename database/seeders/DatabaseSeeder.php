<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed all roles & permissions
        $this->call(RolePermissionSeeder::class,
        AdminSeeder::class,
    );

       
    }
}
