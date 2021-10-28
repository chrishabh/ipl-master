<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApplicationLaunchedDetails extends Model
{
    use HasFactory;

    public static function insertApplicationDetails($data)
    {

        if(!empty($data['device_id']) && !empty($data['andriod_id']) && !empty($data['serial_number']))
        {
            if(ApplicationLaunchedDetails::whereNull('deleted_at')->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->exists())
            {
                return ApplicationLaunchedDetails::whereNull('deleted_at')->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->update($data);
            }else{
                return ApplicationLaunchedDetails::insert($data);
            }
        } else {
            if( !empty($data['device_id']) && ApplicationLaunchedDetails::whereNull('deleted_at')->where('device_id',$data['device_id'])->exists()){

               return ApplicationLaunchedDetails::whereNull('deleted_at')->where('device_id',$data['device_id'])->update($data);

            } elseif (!empty($data['serial_number']) && ApplicationLaunchedDetails::whereNull('deleted_at')->where('serial_number',$data['serial_number'])->exists()) {

              return ApplicationLaunchedDetails::whereNull('deleted_at')->where('serial_number',$data['serial_number'])->update($data);

            }else if (!empty($data['andriod_id']) && ApplicationLaunchedDetails::whereNull('deleted_at')->where('andriod_id',$data['andriod_id'])->exists()) {

              return ApplicationLaunchedDetails::whereNull('deleted_at')->where('andriod_id',$data['andriod_id'])->update($data);

            } else {
                //return ApplicationLaunchedDetails::insert($data);
            }

        }
    }

    public static function getAppLaunchCount()
    {
        $current_date = date("Y-m-d");
        return  ApplicationLaunchedDetails::whereNull('deleted_at')->whereRaw("cast(created_at as date) = '$current_date'")->GroupBy('device_id')->count('device_id');
    }
}
