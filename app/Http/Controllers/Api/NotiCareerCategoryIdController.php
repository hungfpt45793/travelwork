<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Noti_career_category_id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\Entity\User;

class NotiCareerCategoryIdController extends Controller
{
    public function list_noti_carrer(Request $request)
    {
//        try {
            if (!empty($request->token)) {
                $token = $request->input('token');
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 1) {
                    $employee = Employee::select('employee_id','province',
                        'employee_name',
                        'career_category_id', 'user_id')->where('user_id', $user->id)->first();
                    $noti_career_model = new Noti_career_category_id();
                    $total_noti = 0;
                    $list_noti =  $noti_career_model->select(
                        'noti_career_category_id.id_note_career',
                        'noti_career_category_id.title_note',
                        'noti_career_category_id.job_id',
                        'noti_career_category_id.employee_id',
                        'noti_career_category_id.created_at',
                        'noti_career_category_id.updated_at',
                        'jobs.title',
                        'jobs.slug'
                    )
                        ->join('jobs','jobs.job_id','=','noti_career_category_id.job_id')
                        ->where('noti_career_category_id.employee_id',$employee->employee_id);
                        $total_noti = $list_noti->count();
                     $list_noti = $list_noti->orderBy('id_note_career','desc');
                     $list_noti = $list_noti->get();
                    if (!empty($list_noti)) {
                        return response()->json([
                            'status' => 200,
                            'list_noti' => $list_noti,
                            'total_noti' => $total_noti,
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'list_noti' => $list_noti,
                            'total_noti' => $total_noti,
                            'message' => 'Không có thông báo công việc mới mong muốn cho ứng viên',
//                        'user' => $user
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Đây là chức năng thông báo của ứng viên',
                    ], 400);
                }
            }
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
//        } catch (\Exception $e) {
//            return response()->json([
//                'status' => 400,
//                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
//            ], 400);
//        }
    }
    public function delete_noti_post(Request $request)
    {
        try
        {
            $token = $request->input('token');
            $user = JWTAuth::toUser($request->input('token'));
            if ($user->role == 1) {
                $employee = Employee::select('employee_id','province',
                    'employee_name',
                    'career_category_id', 'user_id')->where('user_id', $user->id)->first();
                $id_note_career = $request->input('id_note_career');
                $noti_career_model = new Noti_career_category_id();
                $delete_noti_post = $noti_career_model->where('id_note_career',$id_note_career)
                    ->where('employee_id',$employee->employee_id)
                    ->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Xóa thông báo thành công',
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Xóa thông báo thất bại',
                    'noti' => 'Đây không phải là tài khoản ứng viên',
                ], 400);
            }
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Xóa thông báo thất bại',
            ], 400);
        }

    }


    public function noti_carrer(Request $request)
    {
        try {
            if (!empty($request->token)) {
                $token = $request->input('token');
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 1) {
                    $employee = Employee::select('employee_id',
                        'employee_name','province',
                        'career_category_id', 'user_id')->where('user_id', $user->id)->first();
                    $noti_career_model = new Noti_career_category_id();
                    $noti_career_job = $noti_career_model->select('noti_career_category_id.id_note_career',
                        'noti_career_category_id.title_note',
                        'noti_career_category_id.job_id',
                        'noti_career_category_id.status',
                        'jobs.title',
                        'jobs.slug',
                        'jobs.career_category_id',
                        'jobs.province',
                        'noti_career_category_id.created_at',
                        'career_categories.career_category_name'
                    )
                        ->join('jobs', 'jobs.job_id', '=', 'noti_career_category_id.job_id')
                        ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                        ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'jobs.career_category_id')
                        ->whereDate('noti_career_category_id.created_at', '>=', date('Y-m-d'))
                        ->where('jobs.career_category_id', $employee->career_category_id)
                        ->where('jobs.province', $employee->province)
                        ->where('noti_career_category_id.status', 1)
                        ->orderBy('noti_career_category_id.id_note_career', 'desc');
                    $total_job = $noti_career_job->count();
                    $noti_career_job = $noti_career_job->first();


                    $noti_career_job_facebook = $noti_career_model->select('noti_career_category_id.id_note_career',
                        'noti_career_category_id.title_note',
                        'noti_career_category_id.job_id',
                        'noti_career_category_id.status',
                        'job_facebook.title',
                        'job_facebook.slug',
                        'job_facebook.career_category_id',
                        'job_facebook.province',
                        'noti_career_category_id.created_at',
                        'career_categories.career_category_name'
                    )
                        ->join('job_facebook', 'job_facebook.job_facebook_id', '=', 'noti_career_category_id.job_id')
                        ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'job_facebook.career_category_id')
                        ->whereDate('noti_career_category_id.created_at', '>=', date('Y-m-d'))
                        ->where('job_facebook.career_category_id', $employee->career_category_id)
                        ->where('job_facebook.province', $employee->province)
                        ->where('noti_career_category_id.status', 0)
                    ->orderBy('noti_career_category_id.id_note_career', 'desc');
                    $total_job_facebook = $noti_career_job_facebook->count();
                    $noti_career_job_facebook = $noti_career_job_facebook->first();

//echo '<pre>';
//print_r($noti_career_job_facebook);die();
                    if ((!empty($noti_career_job) && $total_job > 0) || !empty($noti_career_job_facebook) && $total_job_facebook > 0  ) {
                        return response()->json([
                            'status' => 200,
                            'message_job' => 'Việc làm đã kiểm duyệt',
                            'total_job' => $total_job,
                            'noti_career_job' => $noti_career_job,
                            'message_job_facebook' => 'Việc làm chưa kiểm duyệt',
                            'total_job_facebook' => $total_job_facebook,
                            'noti_career_job_facebook' => $noti_career_job_facebook,
//                        'user' => $user
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Không có thông báo công việc mới mong muốn cho ứng viên',
//                        'user' => $user
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Đây là chức năng thông báo của ứng viên',
                    ], 400);
                }
            }
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        }
    }
}
