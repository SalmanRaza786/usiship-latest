<?php

namespace Database\Seeders;

use App\Models\LTDirection;
use App\Models\LTEquipmentType;
use App\Models\LTOperation;
use App\Models\LTTransportaionMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            //direction
            $directionOptions = ['Inbound','Outbound'];
            foreach ($directionOptions as $key=>$val){
                LTDirection::updateOrCreate(['value' =>$val], ['value' =>$val]);
            }

        //Equipment Type
        $eqTypeOptions = ['Dry Van'];
        foreach ($eqTypeOptions as $key=>$val){
            LTEquipmentType::updateOrCreate(['value' =>$val], ['value' =>$val]);
        }

        //Transportation Mode
        $transportOptions = ['FTL','PTL'];
        foreach ($transportOptions as $key=>$val){
            LTTransportaionMode::updateOrCreate(['value' =>$val], ['value' =>$val]);
        }

        // Operation
        $transportOptions = ['Live'];
        foreach ($transportOptions as $key=>$val){
            LTOperation::updateOrCreate(['value' =>$val], ['value' =>$val]);
        }








    }
}
