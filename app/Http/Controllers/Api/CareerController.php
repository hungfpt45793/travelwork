<?php

namespace App\Http\Controllers\Api;

use App\Entity\Career;
use App\Entity\District;
use App\Entity\Province;
use App\Http\Controllers\Controller;
use Validator;

class CareerController extends Controller
{
    //danh sach cong viec caan tim
    public function list_carrer_category()
    {
        try {
            $carrer_model = new Career();
            $list_carrer = $carrer_model->select('career_category_id',
                'career_category_name'
            )
                ->get();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_carrer' => $list_carrer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function list_carrer_category_exam()
    {
        try {
            $carrer_model = new Career();
            $list_carrer = $carrer_model::list_carrer_category_exam();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_carrer' => $list_carrer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function search_carrer_category($career_category_name)
    {
        try {
            $carrer_model = new Career();
            $list_carrer = $carrer_model->select('career_category_id',
                'career_category_name'
            );
            $list_carrer = $list_carrer->where('career_category_name', 'like', '%' . $career_category_name . '%');
            $total = $list_carrer->count();
            $list_carrer = $list_carrer->get();
            if (!empty($list_carrer) && $total > 0) {
                return response()->json([
                    'status' => 200,
                    'descript' => 'thành công',
                    'total' => $total,
                    'list_carrer' => $list_carrer,

                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'descript' => 'Không tìm thấy công việc này ! ',
                    'total' => $total,
                    'list_carrer' => $list_carrer,

                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }


}
