<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApplicationLaunchedDetails extends Model
{
    use HasFactory;

    public static function insertApplicationDetails($request)
    {
        ApplicationLaunchedDetails::insert($request);
    }

    public static function getAppLaunchCount()
    {
        $current_date = date("Y-m-d");
        return  ApplicationLaunchedDetails::whereNull('deleted_at')->whereRaw("cast(created_at as date) = '$current_date'")->GroupBy('device_id')->count('device_id');
    }
}
