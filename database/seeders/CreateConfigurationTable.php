<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class CreateConfigurationTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            // 'name' => 'timeandip',
            'ipDefaut'=>'45.122.246.186',
            'timeStartCheckin'=>'08:00:00',
            'timeEndCheckin'=>'08:15:00',
            'timeStartCheckout'=>'16:50:00',
            'timeEndCheckout'=>'18:00:00',
            'formatDate'=>'d/m/Y'
        ];
        Configuration::create($config);
    }
}
