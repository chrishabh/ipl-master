<?php

namespace App\Services;

use App\Models\ConstructionDetails;
use App\Models\WagesDetails;

class WagesServices{

    public static function bookWages($request)
    {
       WagesDetails::bookWages($request);
    }

    public static function getWages($request)
    {
        return  WagesDetails::getWages($request);
    }

}