<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionDetails extends Model
{
    use HasFactory;

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public static function getConstructionDetails($request)
    {
        $noOfRecord = $request['no_of_records'] ?? 10;
        $current_page = $request['page_number'] ?? 1;
        $offset = ($current_page*$noOfRecord)-$noOfRecord;
        $header = $main_response = $final = $sub_final =[];
        $sub_header = [];
        $return = [];

        $distinct_records = ConstructionDetails::join('main_descritpions', 'main_descritpions.id', '=', 'construction_details.main_description_id')
        ->join('sub_descritpions', 'sub_descritpions.id', '=', 'construction_details.sub_description_id')
        ->select('main_descritpions.description as description_header','sub_descritpions.sub_description')->whereNull('construction_details.deleted_at')
        ->where('apartment_id',$request['apartment_id'])->where('project_id',$request['project_id'])->where('block_id',$request['block_id'])->distinct()->offset($offset)->limit($noOfRecord)->get();

        foreach($distinct_records as $value){
            $header[$value['description_header']] = $value['description_header'];
            $sub_header[$value['sub_description']] = $value['sub_description'];
        }

        $data = ConstructionDetails::join('main_descritpions', 'main_descritpions.id', '=', 'construction_details.main_description_id')
        ->join('sub_descritpions', 'sub_descritpions.id', '=', 'construction_details.sub_description_id')
        ->select('construction_details.*','main_descritpions.description as description_header','sub_descritpions.sub_description')->whereNull('construction_details.deleted_at')
        ->where('apartment_id',$request['apartment_id'])->where('project_id',$request['project_id'])->where('block_id',$request['block_id'])->offset($offset)->limit($noOfRecord)->get();

        $return['total_records'] = ConstructionDetails::whereNull('deleted_at')->where('apartment_id',$request['apartment_id'])->where('project_id',$request['project_id'])->where('block_id',$request['block_id'])->count('id');

        foreach($header as $main_header){
            $final['description_header'] = $main_header;
            foreach($sub_header as $record){
                $sub_final['sub_description'] = $record;
                $sub_final['records'] = [];
                foreach($data as $value){
                    if($final['description_header'] == $value['description_header'] && $sub_final['sub_description'] == $value['sub_description']){
                        $sub_final['records'][] = $value;
                    }
                }
                $final['sub_description_records'][] =  $sub_final;
            }
         
           
            $main_response [] = $final;
        }
        $return['construction_details'] = $main_response;
        return $return;
    }
}
