<?php

namespace App\Http\Helpers;

class Constants
{

    static public $vehicle_classes = [
        1 => 'Class 2A',
        2 => 'Class 2B',
        3 => 'Class 7',
        4 => 'Class 8',
        5 => 'others',
    ];
    static public $class_2A = 1;
    static public $class_2B = 2;
    static public $class_7 = 3;
    static public $class_8 = 4;
    static public $class_Others = 5;


    const ADMIN = 1;
    const USER = 2;

    const INBOUND = 1;
    const OUTBOUND = 2;



}

