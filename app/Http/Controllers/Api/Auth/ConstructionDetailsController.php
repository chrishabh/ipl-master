<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Services\UserServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetApartmentFormRequest;
use App\Http\Requests\GetBlockDetailsFormRequest;
use App\Http\Requests\GetConstructionDetailsFormRequest;
use App\Http\Requests\GetProjectDetialsFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Services\ConstructionDetailsServices;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ConstructionDetailsController extends Controller
{

    public static function getProjectDetails(GetProjectDetialsFormRequest $request)
    {
        $requestData = $request->validated();
        $data = ConstructionDetailsServices::getProjectDetails($request);

        return  response()->data($data);
    }

    public static function getBlockDetails(GetBlockDetailsFormRequest $request)
    {
        $requestData = $request->validated();
        $data = ConstructionDetailsServices::getBlockDetails($request);

        return  response()->data($data);
    }

    public static function getApartmentDetails(GetApartmentFormRequest $request)
    {
        $requestData = $request->validated();
        $data = ConstructionDetailsServices::getApartmentDetails($request);

        return  response()->data($data);
    }

    public static function getConstructionDetails(GetConstructionDetailsFormRequest $request)
    {
        $requestData = $request->validated();
        $data = ConstructionDetailsServices::getConstructionDetails($request);

        return  response()->data($data);
    }
    
}
