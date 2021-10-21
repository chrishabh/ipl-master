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
        if(!(DownloadedVideoDetails::where('device_id',$data['device_id'])->exists())){
            $data['is_new'] = '1';
        }

        if(DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->exists()){

            DownloadedVideoDetails::whereNull('deleted_at')->where('video_id',$data['video_id'])->where('device_id',$data['device_id'])->update($data);

        }else{
            DownloadedVideoDetails::insert($data);
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
        return DownloadedVideoDetails::whereNull('deleted_at')->whereRaw("cast(created_at as date) = '$current_date'")->count('id');
    }
}
