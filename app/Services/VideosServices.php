<?php

namespace App\Services;

use App\Models\ApplicationLaunchedDetails;
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
          
            if(env('APP_ENV') == 'STG-HEROKU'){
                $video_data['video_path'] =  "/".$video_saved_name;
                $request->file->move(public_path(), $video_saved_name);
            }else{
                $video_data['video_path'] =  $user_id."//".$video_saved_name;
                $request->file->move($dir_name, $video_saved_name);
            }
            
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
                "serial_number" => $request->serial_number,
                "andriod_id" => $request->andriod_id,
            ];
            DownloadedVideoDetails::insertDownloadedVideoDetails($data);
            if(env('APP_ENV') == 'STG-HEROKU'){
                return ['download_path'=>env('APP_URL').$path->video_path];
            }else{
                return ['download_path'=>env('APP_URL')."/videos"."/".$path->video_path];
            }
        }
        return ['download_path'=>env('APP_URL')];
    }

    public static function getVideoList($request)
    {
        $data = videosDetails::getVideoList($request);

        foreach($data['video_details'] as &$value)
        {
            $value['viewers_count'] = DownloadedVideoDetails::getViewersOfVideo($value['id']);
            if(env('APP_ENV') == 'STG-HEROKU'){
                $value['video_path'] = env('APP_URL').$value['video_path'];
            }else{
                $value['video_path'] = env('APP_URL')."/videos"."/".$value['video_path'];
            }
        }

        return $data;
    }

    public static function getAppLaunchCount()
    {
        $data['app_launch_count'] = ApplicationLaunchedDetails::getAppLaunchCount();
        $data['total_video_views'] = DownloadedVideoDetails::getTotalCountViewedVideo(date("Y-m-d"));
        return $data;
    }

}
