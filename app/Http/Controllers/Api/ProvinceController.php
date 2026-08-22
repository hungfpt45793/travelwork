<?php

namespace App\Http\Controllers\Api;

use App\Entity\District;
use App\Entity\Province;
use App\Http\Controllers\Controller;
use Validator;

class ProvinceController extends Controller
{
    public function list_province()
    {
        try
        {
            $province_model = new Province();
            $list_province = $province_model->select('province_id',
                'province_name',
                'postalcode')
                ->orderBy('sort_id','asc')
                ->get();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_district' => $list_province
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }
    public function search_province($province_name)
    {
        try
        {
            $province_model = new Province();
            $list_province = $province_model->select('province_id',
                'province_name',
                'postalcode')
                ->where('province_name','like','%'.$province_name.'%')
                ->orderBy('sort_id','asc');
            $total = $list_province->count();
            $list_province = $list_province->get();

            if(!empty($list_province) && $total > 0)
            {
                return response()->json([
                    'status' => 200,
                    'descript' => 'thành công',
                    'total' => $total,
                    'list_district' => $list_province,

                ],200);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'descript' => 'Không tìm thấy thành phố này ! ',
                    'total' => $total,
                    'list_district' => $list_province,

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
