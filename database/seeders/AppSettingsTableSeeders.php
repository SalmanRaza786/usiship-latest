<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_title',
                'value' => 'USHIP',
                'description' => 'USHIP',
            ],
            [
                'key' => 'app_logo',
                'value' => 'logo-light.png',
                'description' => 'USHIP Logo',
            ],

            [
                'key' => 'admin_bg',
                'value' => 'auth.jpg',
                'description' => 'Auth BG',
            ],
            [
                'key' => 'student_bg',
                'value' => 'auth.jpg',
                'description' => 'E-Learning Student Logo',
            ],
            [
                'key' => 'std_slide_text',
                'value' => 'Great! Clean code, clean design, easy for customization. Thanks very much! ',
                'description' => 'E-Learning Student Slider Text',
            ],
            [
                'key' => 'std_slide_text1',
                'value' => 'Great! Clean code, clean design, easy for customization. Thanks very much! ',
                'description' => 'E-Learning Student Slider Text',
            ],
            [
                'key' => 'std_slide_text2',
                'value' => 'Lecture classes are available online or can be attended in the branch in a separate lecture room! ',
                'description' => 'E-Learning Student Slider Text',
            ],


            [
                'key' => 'footer_note',
                'value' => 'USHIP',
                'description' => 'Footer Text',
            ],
            [
                'key' => 'allow_registration',
                'value' => 1,
                'description' =>'1 use for allow 2 use for not allow',
            ],


        ];

        // Loop through the array and create records in the database
//        foreach ($settings as $row) {
//            AppSetting::updateOrCreate($row);
//        }


        foreach ($settings as $row){
            AppSetting::updateOrCreate(
                ['key' =>$row['key']],
                [
                    'key' => $row['key'],
                    'value' => $row['value'],
                    'description' => $row['description'],
                ]);
        }
    }
}
