<?php

namespace App\Http\Controllers\Api;

use App\Entity\District;
use App\Entity\Province;
use App\Http\Controllers\Controller;
use Validator;

class DistrictController extends Controller
{
    public function list_district()
    {
        try
        {
            $district_model = new District();
            $list_district = $district_model->select('district.district_id',
                'district.district_name',
                'district.province_id',
                'province.province_name')
                ->join('province','province.province_id','=','district.province_id')
                ->get();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_district' => $list_district
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }
    public function search_district($distrcit_name)
    {
        try
        {
            $district_model = new District();
            $list_district = $district_model->select('district.district_id',
                'district.district_name',
                'district.province_id',
                'province.province_name')
                ->join('province','province.province_id','=','district.province_id')
                ->where('district.district_name','like','%'.$distrcit_name.'%');
            $total = $list_district->count();
                $list_district =$list_district->get();
                if(!empty($list_district) && $total > 0)
                {
                    return response()->json([
                        'status' => 200,
                        'descript' => 'thành công',
                        'total' => $total,
                        'list_district' => $list_district
                    ],200);
                }
                else
                {
                    return response()->json([
                        'status' => 404,
                        'descript' => 'Không tìm thấy quận / huyện này ! ',
                        'total' => $total,
                        'list_district' => $list_district

                    ],404);
                }

        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }
    public function list_district_province($pronvice_id)
    {
        try
        {
            $a = new Province();
            $district_model = new District();
            $list_district = $district_model->select('district.district_id',
                'district.district_name',
                'district.province_id',
                'province.province_name'
            )
                ->join('province','province.province_id','=','district.province_id')
                ->where('district.province_id',$pronvice_id)
                ->get();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_district' => $list_district
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }
    public function search_district_province($pronvice_id,$distrcit_name)
    {
        try
        {
            $a = new Province();
            $district_model = new District();
            $list_district = $district_model->select('district.district_id',
                'district.district_name',
                'district.province_id',
                'province.province_name'
            )
                ->join('province','province.province_id','=','district.province_id')
                ->where('district.province_id',$pronvice_id)
                ->where('district.district_name','like','%'.$distrcit_name.'%');
            $total = $list_district->count();
            $list_district = $list_district->get();
            if(!empty($list_district) && $total > 0)
            {
                return response()->json([
                    'status' => 200,
                    'descript' => 'thành công',
                    'total' => $total,
                    'list_district' => $list_district
                ],200);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'descript' => 'Không tìm thấy quận / huyện này ! ',
                    'total' => $total,
                    'list_district' => $list_district

                ],404);
            }
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }

}
