<?php

namespace Database\Seeders;


use App\Models\OperationalHour;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class OperationalHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = Carbon::createFromTime(0, 0);
        $endTime = Carbon::createFromTime(23, 30);

        // Generate time intervals
        while ($startTime <= $endTime) {
            $formattedTime = $startTime->format('H:i');
            OperationalHour::updateOrCreate(
                ['working_hour' => $formattedTime],
                ['working_hour' => $formattedTime],
            );

            $startTime->addMinutes(30);
        }
    }
    }
