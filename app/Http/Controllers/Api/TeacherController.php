<?php

namespace App\Http\Controllers\Api;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Input;
use App\Entity\Job;
use App\Entity\Post;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\User_show_password;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class TeacherController extends Controller
{
//http://sanketoan.local/api/tin-tuc/kinh-nghiem-de-tuyen-dung-duoc-mot-ke-toan-tong-hop-co-ky-nang-xu-ly-cong-viec-gioi
    public function getListTeacher($local_area)
    {

        $teacher_model = new Teacher();
        $list_teacher = $teacher_model->select(
            'teacher.teacher_name',
            'teacher.slug',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'teacher.teacher_info',
            'teacher.address',
            'teacher.gender',
            'teacher.birthday',
            'teacher.information_verifier',
            'province.local_area',
            'province.province_name',
            'district.district_name',
            'type_of_business.type_of_business_name'
        )
            ->leftJoin('province', 'province.province_id', '=', 'teacher.province')
            ->leftJoin('district', 'district.district_id', '=', 'teacher.district')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'teacher.business_type_id')
            ->where('province.local_area', $local_area)->get();

        if (empty($list_teacher)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'list_teacher' => $list_teacher,
        ], 200);
    }

    public function searchTeacher(Request $request)
    {

        $teacher_model = new Teacher();
        $list_teacher = $teacher_model->select(
            'teacher.teacher_name',
            'teacher.slug',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'teacher.teacher_info',
            'teacher.address',
            'teacher.gender',
            'teacher.birthday',
            'teacher.information_verifier',
            'province.local_area',
            'province.province_name',
            'district.district_name',
            'type_of_business.type_of_business_name'
        )
            ->leftJoin('province', 'province.province_id', '=', 'teacher.province')
            ->leftJoin('district', 'district.district_id', '=', 'teacher.district')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'teacher.business_type_id');
        if (!empty($request->input('province_id'))) {
            $list_teacher = $list_teacher->where('teacher.province', $request->input('province_id'));
        }
        if (!empty($request->input('district_id'))) {
            $list_teacher = $list_teacher->where('teacher.district', $request->input('district_id'));
        }
        if (!empty($request->input('type_of_business_id'))) {
            $list_teacher = $list_teacher->where('teacher.business_type_id', $request->input('type_of_business_id'));
        }
        $list_teacher = $list_teacher->get();

        if (empty($list_teacher)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'list_teacher' => $list_teacher,
        ], 200);
    }

    public function getDetail($slug_teacher)
    {

        $teacher_model = new Teacher();
        $teacher = $teacher_model->select('teacher.*', 'province.local_area', 'province.province_name', 'district.district_name', 'type_of_business.type_of_business_name')
            ->leftJoin('province', 'province.province_id', '=', 'teacher.province')
            ->leftJoin('district', 'district.district_id', '=', 'teacher.district')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'teacher.business_type_id')
            ->where('teacher.slug', $slug_teacher)
            ->first();
        $teacher_spec_model = new Teacher_specialize();
        $teacher_spec = $teacher_spec_model->select('teacher_specialize.*')
            ->leftJoin('teacher', 'teacher.teacher_id', '=', 'teacher_specialize.teacher_id')
            ->where('teacher.slug', $slug_teacher)
            ->get();
        $teacher_ex_model = new Teacher_experience();
        $teacher_ex = $teacher_ex_model->select('teacher_experience.*')
            ->leftJoin('teacher', 'teacher.teacher_id', '=', 'teacher_experience.teacher_id')
            ->where('teacher.slug', $slug_teacher)
            ->get();

        if (empty($teacher)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'thong-tin' => 'Thông tin giáo viên',
            'teacher' => $teacher,
            'trinh-do' => 'Trình độ giáo viên',
            'teacher_spec' => $teacher_spec,
            'kinh-nghiem' => 'Kinh nghiệm giáo viên',
            'teacher_ex' => $teacher_ex,
        ], 200);
    }

    public function loginTeacher(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => '400',
                    'error' => 'Thông tin tài khoản hoặc mật khẩu không chính xác',
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ], 400);
            }
        } catch (JWTException $exception) {
            return response()->json(
                ['error' => 'Không thể tạo token. Đã có lỗi xảy ra',
                    'email' => $request->email,
                    'password' => $request->password,
                ], 500
            );
        }
        $user = User::select('id',
            'email',
            'password',
            'phone',
            'role',
            'name'
        )->where('email', $request->input('email'))
            ->first();
        $taikhoan = '';
        if ($user->role != 3) {
            return response()->json([
                'status' => 404,
                'message' => 'Vui lòng đăng nhập tài khoản giáo viên',
            ], 404);
        }
//        $teacher_model = new Teacher();
//        $teacher = $teacher_model->select('teacher.*', 'province.local_area', 'province.province_name', 'district.district_name', 'type_of_business.type_of_business_name')
//            ->join('province', 'province.province_id', '=', 'teacher.province')
//            ->join('district', 'district.district_id', '=', 'teacher.district')
//            ->join('type_of_business', 'type_of_business.type_of_business_id', '=', 'teacher.business_type_id')
//            ->where('teacher.user_id', $user->id)
//            ->first();
        return response()->json([
            'status' => 200,
            'token' => $token,
            'user' => $user,
        ], 200);

    }

    public function getInfoTeacher($user_id)
    {

        $teacher_model = new Teacher();
        $teacher = $teacher_model->select('teacher.*', 'province.local_area', 'province.province_name', 'district.district_name', 'type_of_business.type_of_business_name')
            ->leftJoin('province', 'province.province_id', '=', 'teacher.province')
            ->leftJoin('district', 'district.district_id', '=', 'teacher.district')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'teacher.business_type_id')
            ->where('teacher.user_id', $user_id)
            ->first();
        $teacher_spec_model = new Teacher_specialize();
        $teacher_spec = $teacher_spec_model->select('teacher_specialize.*')
            ->leftJoin('teacher', 'teacher.teacher_id', '=', 'teacher_specialize.teacher_id')
            ->where('teacher.user_id', $user_id)
            ->get();
        $teacher_ex_model = new Teacher_experience();
        $teacher_ex = $teacher_ex_model->select('teacher_experience.*')
            ->leftJoin('teacher', 'teacher.teacher_id', '=', 'teacher_experience.teacher_id')
            ->where('teacher.user_id', $user_id)
            ->get();

        if (empty($teacher)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'thong-tin' => 'Thông tin giáo viên',
            'teacher' => $teacher,
            'trinh-do' => 'Trình độ giáo viên',
            'teacher_spec' => $teacher_spec,
            'kinh-nghiem' => 'Kinh nghiệm giáo viên',
            'teacher_ex' => $teacher_ex,
        ], 200);
    }


//    api lấy thông tin giáo viên để chuyển tài khoản
    public function getAcount($user_id)
    {
        $user_model = new User_show_password();
        $user = $user_model->select('email',
            'accesstoken',
            'phone',
            'image',
            'role',
            'name',
            'gender',
            'age',
            'address',
            'point',
            'provider',
            'provider_id',
            'created_at')
            ->where('id',$user_id)
            ->where('role',3)
            ->first();
        if (empty($user)) {
            return response([
                'status' => 404,
            ], 404);
        }
        return response([
            'status' => 200,
            'user' => $user,
        ], 200);
    }

    public function getInfo($teacher_id)
    {
        $teacher_model = new Teacher();
        $teacher = $teacher_model->select('*')->where('teacher_id',$teacher_id)->first();
        if (empty($teacher)) {
            return response([
                'status' => 404,
            ], 404);
        }
        return response([
            'status' => 200,
            'teacher' => $teacher,
        ], 200);
    }

    public function getSpecialize($teacher_id)
    {
        $teacher_spec_model = new Teacher_specialize();
        $teacher_spec = $teacher_spec_model->select('*')->where('teacher_id',$teacher_id)->get();
        if (empty($teacher_spec)) {
            return response([
                'status' => 404,
            ], 404);
        }
        return response([
            'status' => 200,
            'teacher_spec' => $teacher_spec,
        ], 200);
    }

        public function getExperience($teacher_id)
    {
        $teacher_ex_model = new Teacher_experience();
        $teacher_ex = $teacher_ex_model->select('*')->where('teacher_id',$teacher_id)->get();
        if (empty($teacher_ex)) {
            return response([
                'status' => 404,
            ], 404);
        }
        return response([
            'status' => 200,
            'teacher_ex' => $teacher_ex,
        ], 200);
    }

    public function getAcouting($teacher_id)
    {
        $teacher_model = new Teacher();
        $update = $teacher_model->where('teacher_id',$teacher_id)->update([
            'status_accounting' => 1
        ]);
        return response([
            'status' => 200,
        ], 200);
    }
}
