<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\ProcessingTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessingTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderTasks = [
            [
                'name' => 'Carton Labels',
                'status' => 1,
            ],
            [
                'name' => 'Pallet Labels',
                'status' => 1,
            ],
            [
                'name' => 'Pallets Used',
                'status' => 1,
            ],
            [
                'name' => 'Stretch Wrap',
                'status' => 1,
            ],
            [
                'name' => 'Other work',
                'status' => 1,
            ],

        ];
        foreach ($orderTasks as $task){
            ProcessingTask::updateOrCreate(
                ['name' =>$task['name']],
                [
                    'name' => $task['name'],
                    'status' => $task['status'],
                ]);
        }
    }
}
