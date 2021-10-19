<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class videosDetails extends Model
{
    use HasFactory;

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public static function uploadVideos($data)
    {
        return videosDetails::insertGetId($data);
    }

    public static function downloadVideos($id)
    {
        return videosDetails::select('video_path')->whereNull('deleted_at')->where('id',$id)->first();
    }

    public static function getVideoList($request)
    {
        $noOfRecord = $request['no_of_records'] ?? 10;
        $current_page = $request['page_number'] ?? 1;
        $offset = ($current_page*$noOfRecord)-$noOfRecord;
        $user_id = (isset(Auth::User()->id))?Auth::User()->id:null;

        $return['total_records'] = videosDetails::whereNull('deleted_at')->count('id');

        $data = videosDetails::select('id','video_name','video_path')->whereNull('deleted_at')->where('user_id',$user_id)->offset($offset)->limit($noOfRecord)->get();
        $return['video_details'] = [];
        if(count($data)>0){
            $return['video_details'] = $data->toArray();
        }
        return $return;
    }
}
