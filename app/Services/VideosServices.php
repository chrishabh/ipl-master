<?php

namespace App\Services;

use App\Models\DownloadedVideoDetails;
use App\Models\videosDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VideosServices{

    public static function uploadVideos($request)
    {
        $user_id = (isset(Auth::User()->id))?Auth::User()->id:null;
        if (isset($_FILES) && !empty($_FILES['request']['name']['file'])) {
            $dir_name =  env('VIDEOS_PATH').$user_id;
            if (!is_dir($dir_name)) {
                @mkdir($dir_name);
            }

            $current_timestamp  = Carbon::now()->timestamp;
            $video_saved_name = $current_timestamp . $_FILES['request']['name']['file'];
            
            $video_data['video_name'] =  $user_id;
            $video_data['video_name'] =  $_FILES['request']['name']['file'];
            $video_data['video_path'] =  $user_id."//".$video_saved_name;
            $request->file->move(public_path().'/storage', $video_saved_name);
            $video_id['video_id'] = videosDetails::uploadVideos($video_data);
            return $video_id;

        }
    }

    public static function downloadVideos($request)
    {
        $user_id = (isset(Auth::User()->id))?Auth::User()->id:null;
        $path = videosDetails::downloadVideos($request->id);
        if(!empty($path))
        {
            $data = [
                "video_id" => $request->id,
                "device_id" => $request->device_id,
            ];
            DownloadedVideoDetails::insertDownloadedVideoDetails($data);
            return ['download_path'=>env('APP_URL')."/videos"."/".$path->video_path];
        }
        return ['download_path'=>env('APP_URL')];
    }

    public static function getVideoList($request)
    {
        $data = videosDetails::getVideoList($request);

        foreach($data['video_details'] as &$value)
        {
            $value['video_path'] = env('APP_URL')."/videos"."/".$value['video_path'];
        }

        return $data;
    }

    public static function getVideoCount()
    {
        $data = DownloadedVideoDetails::getTotalRecords();

        return $data;
    }

}
