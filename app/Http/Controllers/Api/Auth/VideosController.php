<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginFormRequest;
use App\Services\UserServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadVideosFormRequest;
use App\Http\Requests\GetVideosListFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Http\Requests\UploadVideosFormRequest;
use App\Services\VideosServices;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public static function uploadVideo(UploadVideosFormRequest $request)
    {
        $requestData = $request->validated();
    
        $return = VideosServices::uploadVideos($request);

		return  response()->data($return);
    }

    public static function downloadVideo(DownloadVideosFormRequest $request)
    {
        $requestData = $request->validated();

        $return = VideosServices::downloadVideos($request);

		return  response()->data($return);

    }

    public static function getVideosList(GetVideosListFormRequest $request)
    {
        $requestData = $request->validated();

        $return = VideosServices::getVideoList($request);

		return  response()->data($return);

    }

    public function getApplicationLaunchCount()
    {
        

        $return = VideosServices::getAppLaunchCount();

		return  response()->data($return);

    }
    
}
