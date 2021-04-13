<?php

namespace Database\Seeders;

use App\Models\ColorEvent;
use Illuminate\Database\Seeder;

class CreateColorEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = array(
            ['className' => 'bg-primary', 'name' => 'Primary'],
            ['className' => 'bg-success', 'name' => 'Success'],
            ['className' => 'bg-purple', 'name' => 'Purple'],
            ['className' => 'bg-danger', 'name' => 'Danger'],
            ['className' => 'bg-pink', 'name' => 'Pink'],
            ['className' => 'bg-info', 'name' => 'Info'],
            ['className' => 'bg-inverse', 'name' => 'Inverse'],
            ['className' => 'bg-warning', 'name' => 'Warning']);
        foreach ($t as $key => $value) {
            ColorEvent::create($value);
        }
    }
}
