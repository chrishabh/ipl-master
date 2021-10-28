<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DownloadedVideoDetails extends Model
{
    use HasFactory;

    public static function insertDownloadedVideoDetails($data)
    {

        if(!empty($data['device_id']) && !empty($data['andriod_id']) && !empty($data['serial_number']))
        {
            if(DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->exists())
            {
                return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->update($data);
            }else{
                return DownloadedVideoDetails::insert($data);
            }
        }
        // } elseif(!empty($data['device_id']) && !empty($data['andriod_id'])){
        //     if(DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->exists())
        //     {
        //         return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('andriod_id',$data['andriod_id'])->update($data);
        //     }else{
        //         return DownloadedVideoDetails::insert($data);
        //     }
        // } elseif (!empty($data['andriod_id']) && !empty($data['serial_number'])){

        //     if(DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->exists())
        //     {
        //         return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('andriod_id',$data['andriod_id'])->where('serial_number',$data['serial_number'])->update($data);
        //     }else{
        //         return DownloadedVideoDetails::insert($data);
        //     }

        // } elseif (!empty($data['serial_number']) && !empty($data['device_id'])) {

        //     if(DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('serial_number',$data['serial_number'])->exists())
        //     {
        //         return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->where('serial_number',$data['serial_number'])->update($data);
        //     } else {
        //         return DownloadedVideoDetails::insert($data);
        //     }

        // } 
        else {
            if( !empty($data['device_id']) && DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->exists()){

               return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->update($data);

            } elseif (!empty($data['serial_number']) && DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('serial_number',$data['serial_number'])->exists()) {

              return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('serial_number',$data['serial_number'])->update($data);

            }else if (!empty($data['andriod_id']) && DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('andriod_id',$data['andriod_id'])->exists()) {

              return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('andriod_id',$data['andriod_id'])->update($data);

            } else {
                return DownloadedVideoDetails::insert($data);
            }

        }
    }

    public static function getTotalRecords()
    {
        $old_client = DB::SELECT("SELECT count(device_id) as old_count,video_id from downloaded_video_details where deleted_at IS NULL AND is_new = '0' Group By video_id");
        $new_client = DB::SELECT("SELECT count(device_id) as new_count,video_id from downloaded_video_details where deleted_at IS NULL AND is_new = '1' Group By video_id");

        $old_count = json_decode(json_encode($old_client), true);
        $new_count = json_decode(json_encode($new_client), true);
        $return['old_viewers'] = $old_count;
        $return['new_viewers'] = $new_count;

        return $return;
    }

    public static function getViewersOfVideo($video_id)
    {
        return DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$video_id)->count('id');
    }

    public static function getTotalCountViewedVideo($current_date){
        return DownloadedVideoDetails::whereNull('deleted_at')->count('id');
    }
}
