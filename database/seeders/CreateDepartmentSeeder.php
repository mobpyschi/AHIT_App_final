<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class CreateDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Admin',
            'Accounting Department',
            'Technical Department',
         ];

         foreach ($departments as $department) {
              Department::create(['name' => $department]);
         }
    }
}
