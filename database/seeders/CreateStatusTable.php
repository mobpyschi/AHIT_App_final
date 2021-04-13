<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class CreateStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'New',
            'InProgress',
            'Pending',
            'overDue',
            'Done'
        ];
        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
