<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateDepartmentSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateRoleSeeder::class);
        $this->call(CreateConfigurationTable::class);
        $this->call(CreateStatusTable::class);
        $this->call(CreateColorEventSeeder::class);
    }
}
