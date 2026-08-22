<?php

namespace App\Http\Controllers\Api;

use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employer_select_response;
use App\Entity\Experience;
use App\Entity\Literacy;
use App\Entity\Province;
use App\Entity\TypeOfBusiness;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;

class LiteracyController extends Controller
{
    public function list_literacy()
    {
        try {
            $literacy = new Literacy();
            $list_literacy = $literacy->select('literacy_id',
                'literacy_name'
            )->orderBy('literacy_id', 'asc')
                ->get();

            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_literacy' => $list_literacy
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function list_type_of_business_id()
    {
        try {
            $literacy = new TypeOfBusiness();
            $list_literacy = $literacy->select('type_of_business_id', 'type_of_business_name', 'type_of_business_slug'
            )->orderBy('type_of_business_id', 'asc')
                ->get();

            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'type_of_business' => $list_literacy
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }
    public function list_type_of_business_id_exam()
    {
        try {
            $literacy = new TypeOfBusiness();
            $list_literacy = $literacy::list_type_of_business_id_exam();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'type_of_business' => $list_literacy
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function list_business()
    {
        try {
            $literacy = new Business();
            $list_literacy = $literacy->select('business_type_id', 'business_type_name', 'business_type_slug'
            )->orderBy('business_type_id', 'asc')
                ->get();

            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_business' => $list_literacy
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function list_profile()
    {
        try {
            $list_profile[0]['title'] = 'Từ 40 điểm - 50 điểm ';
            $list_profile[0]['profile'] = '40,50';
            $list_profile[1]['title'] = 'Từ 50 điểm - 60 điểm ';
            $list_profile[1]['profile'] = '50,60';
            $list_profile[2]['title'] = 'Từ 60 điểm - 70 điểm ';
            $list_profile[2]['profile'] = '60,70';
            $list_profile[3]['title'] = 'Trên 70 điểm ';
            $list_profile[3]['profile'] = '70,100';


            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_profile' => $list_profile
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function list_status()
    {
        try {
            $list_status[0]['title'] = 'Chưa đi làm';
            $list_status[0]['status'] = '0';
            $list_status[1]['title'] = 'Đã đi làm';
            $list_status[1]['status'] = '1';


            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_status' => $list_status
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }


    public function list_time_to_work()
    {
        try {
            $list_time_to_work[0]['title'] = '1 năm kinh nghiệm';
            $list_time_to_work[0]['time_to_work'] = '1';
            $list_time_to_work[1]['title'] = '2 năm kinh nghiệm';
            $list_time_to_work[1]['time_to_work'] = '2';
            $list_time_to_work[2]['title'] = '3 năm kinh nghiệm';
            $list_time_to_work[2]['time_to_work'] = '3';
            $list_time_to_work[3]['title'] = '4 năm kinh nghiệm';
            $list_time_to_work[3]['time_to_work'] = '4';
            $list_time_to_work[4]['title'] = '5 năm kinh nghiệm';
            $list_time_to_work[4]['time_to_work'] = '5';
            $list_time_to_work[5]['title'] = 'Trên 5 năm kinh nghiệm';
            $list_time_to_work[5]['time_to_work'] = '6';

            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_time_to_work' => $list_time_to_work
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ], 400);
        }
    }

    public function check_tax_code($tax_code, Request $request)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => true,
                "verify_peer_name" => true,
            ),
        );
//        $response = file_get_contents('https://sanketoan.vn/api/ma-so-thue/'.$tax_code, false, stream_context_create($arrContextOptions));
        $response = file_get_contents('https://thongtindoanhnghiep.co/api/company/' . $tax_code, false, stream_context_create($arrContextOptions));
        $response = json_decode($response);
        $province_id = Province::where('province_name', 'like', '%' . $response->TinhThanhTitle . '%')->value('province_id');
        $district_id = District::where('district_name', 'like', '%' . $response->QuanHuyenTitle . '%')->value('district_id');

        if (!empty($response->DiaChiCongTy)) {
            $response->province_id = $province_id;
            $response->district_id = $district_id;
            $response = json_encode($response);
//        echo '<pre>';
//        print_r($response);die;
            return $response;
        }

    }

//    danh sach phản hoi cua ung vien
    public function list_employer_select_response(Request $request)
    {
        $employer_select_response = Employer_select_response::get();
        return response()->json([
            'status' => 200,
            'descript' => 'Danh sách phản hồi của ứng viên',
            'list_select' => $employer_select_response
        ], 200);
    }


}
