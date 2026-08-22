<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class JobFaceBookController extends Controller
{
    public function category_job_facebook(Request $request)
    {
        $jobFb_model = new JobFacebook();
        $list_job_fb = $jobFb_model->select(
            'job_facebook.job_facebook_id',
            'job_facebook.date_end',
            'job_facebook.vip',
            'job_facebook.updated_at',
            'job_facebook.number_recruit',
            'job_facebook.warning_job_fb',
            'job_facebook.job_facebook_code',
            'job_facebook.title',
            'job_facebook.slug',
            'job_facebook.company_name',
            'salary.description as salary_description','district.district_name','province.province_name'
        );
        $list_job_fb = $list_job_fb->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id')
            ->leftJoin('province', 'province.province_id', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', 'job_facebook.district');
        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
        $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
        $total = $list_job_fb->count();
        $list_job_fb = $list_job_fb->paginate(20);

        foreach ($list_job_fb as $id => $jobs) {
            $list_jobs[$id]['image'] = !empty($jobs->image) ? asset($jobs->image) : '';
            $status_save_job = 0;
            $string_save_job = 'Chưa lưu';
            $status_submit_job = 0;
            $string_submit_job = 'Chưa nộp hồ sơ';

            if (!empty($request->token)) {
                try {
                    $user = JWTAuth::toUser($request->token);
                    if ($user->role == 1) {
                        $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                        $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $jobs->job_facebook_id, 0);
                        $status_save_job = !empty($check_save_job) ? 1 : 0;
                        $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                        $check_submit_from = Employee_submit_job_faacebook::where('employee_id',$employee_id)
                            ->where('status_job',0)
                            ->where('id_job_fb',$jobs->job_facebook_id)
                            ->first();
                        $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                        $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                        $list_jobs[$id]['employee_id'] = $employee_id;
                    }
                } catch (\Exception $exception) {

                }
            }
            $list_job_fb[$id]['status_save_job'] = $status_save_job;
            $list_job_fb[$id]['string_save_job'] = $string_save_job;
            $list_job_fb[$id]['status_submit_job'] = $status_submit_job;
            $list_job_fb[$id]['string_submit_job'] = $string_submit_job;

            $submit_profile = Employee_submit_job_faacebook::where('id_job_fb', $jobs->job_facebook_id)
                ->where('status_job', 0)
                ->count();
            $list_job_fb[$id]['total_submit_profile'] = !empty($submit_profile) ? $submit_profile : 0;
        }

        if(empty($list_job_fb)){
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ],404);
        }
        return response([
            'status' => 200,
            'list_job_fb' => $list_job_fb,
            'total' => $total,
        ],200);
    }
    public function search_job_facebook(Request $request)
    {
        $jobFb_model = new JobFacebook();
        $list_job_fb = $jobFb_model->select(
            'job_facebook.job_facebook_id',
            'job_facebook.date_end',
            'job_facebook.vip',
            'job_facebook.updated_at',
            'job_facebook.warning_job_fb',
            'job_facebook.job_facebook_code',
            'job_facebook.title',
            'job_facebook.slug',
            'job_facebook.company_name',
            'job_facebook.career_category_id',
            'salary.description as salary_description','district.district_name','province.province_name'
        );
        $list_job_fb = $list_job_fb->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id')
            ->leftJoin('province', 'province.province_id', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', 'job_facebook.district');
        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);


        if (!empty($request->input('career_category_id'))) {
            $list_job_fb = $list_job_fb
                ->where('job_facebook.career_category_id', $request->input('career_category_id'));
        }

        if (!empty($request->input('district_id'))) {
            if (!empty($request->input('district_id'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.district', $request->input('district_id'));
            }
        } else {
            if (!empty($request->input('province_id'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.province', $request->input('province_id'));
            }
        }
        if (!empty($request->input('salary_id'))) {
            $list_job_fb = $list_job_fb->where('job_facebook.salary_id', $request->input('salary_id'));
        }
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $list_job_fb = $list_job_fb->where('job_facebook.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->has('vip'))) {
            $vip = $request->input('vip');
            if ($vip != '') {
                $list_job_fb = $list_job_fb->where('job_facebook.vip', $vip);
            }
        }
        if ($request->input('date_create')) {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '>=', $request->input('date_create'));
            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '<=', date('Y-m-d'));
        }
//        sắp xếp theo lương
        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
        $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
        $total = $list_job_fb->count();
        $list_job_fb = $list_job_fb->paginate(20);
        foreach ($list_job_fb as $id => $jobs) {
            $list_jobs[$id]['image'] = !empty($jobs->image) ? asset($jobs->image) : '';
            $status_save_job = 0;
            $string_save_job = 'Chưa lưu';
            $status_submit_job = 0;
            $string_submit_job = 'Chưa nộp hồ sơ';

            if (!empty($request->token)) {
                try {
                    $user = JWTAuth::toUser($request->token);
                    if ($user->role == 1) {
                        $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                        $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $jobs->job_facebook_id, 0);
                        $status_save_job = !empty($check_save_job) ? 1 : 0;
                        $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                        $check_submit_from = Employee_submit_job_faacebook::where('employee_id',$employee_id)
                            ->where('status_job',0)
                            ->where('id_job_fb',$jobs->job_facebook_id)
                            ->first();
                        $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                        $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                        $list_jobs[$id]['employee_id'] = $employee_id;
                    }
                } catch (\Exception $exception) {

                }
            }
            $list_job_fb[$id]['status_save_job'] = $status_save_job;
            $list_job_fb[$id]['string_save_job'] = $string_save_job;
            $list_job_fb[$id]['status_submit_job'] = $status_submit_job;
            $list_job_fb[$id]['string_submit_job'] = $string_submit_job;
        }
        if(empty($list_job_fb)){
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ],404);
        }
        return response([
            'status' => 200,
            'list_job_fb' => $list_job_fb,
            'total' => $total,
        ],200);
    }
    public function job_facebook_detail($slug,Request $request)
    {
        $job_facebook = JobFacebook::leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id')
            ->leftJoin('province', 'province.province_id', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', 'job_facebook.district')
            ->leftJoin('career_categories', 'career_categories.career_category_id', 'job_facebook.career_category_id')
            ->select(
                'salary.description as salary_description',
                'district_name',
                'province_name',
                'career_categories.career_category_name',
                'job_facebook.job_facebook_id',
                'job_facebook.job_facebook_code',
                'job_facebook.title',
                'job_facebook.des_facebook',
                'job_facebook.content',
                'job_facebook.slug',
                'job_facebook.phone',
                'job_facebook.email',
                'job_facebook.address',
                'job_facebook.date_end',
                'job_facebook.warning_job_fb',
                'job_facebook.company_name',
                'job_facebook.job_info_contact',
                'job_facebook.view',
                'job_facebook.updated_at'
            )
            ->where('job_facebook.slug', $slug)
            ->first();
        $job_facebook['image'] = !empty($job_facebook->image) ? asset($job_facebook->image) : '';
        $status_save_job = 0;
        $string_save_job = 'Chưa lưu';
        $status_submit_job = 0;
        $string_submit_job = 'Chưa nộp hồ sơ';

        if (!empty($request->token)) {
            try {
                $user = JWTAuth::toUser($request->token);
                if ($user->role == 1) {
                    $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                    $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $job_facebook->job_facebook_id, 0);
                    $status_save_job = !empty($check_save_job) ? 1 : 0;
                    $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                    $check_submit_from = Employee_submit_job_faacebook::where('employee_id',$employee_id)
                        ->where('status_job',0)
                        ->where('id_job_fb',$job_facebook->job_facebook_id)
                        ->first();
                    $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                    $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                    $list_jobs['employee_id'] = $employee_id;
                }
            } catch (\Exception $exception) {

            }
        }
        $job_facebook['status_save_job'] = $status_save_job;
        $job_facebook['string_save_job'] = $string_save_job;
        $job_facebook['status_submit_job'] = $status_submit_job;
        $job_facebook['string_submit_job'] = $string_submit_job;
        $view = $job_facebook->view + 1;
        $view_jobFacebook = JobFacebook::select('*')->where('job_facebook.slug', $slug)->update([
            'view' => $view
        ]);
        if(empty($job_facebook)){
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ],404);
        }
        return response([
            'status' => 200,
            'job_facebook' => $job_facebook,
        ],200);
    }


    public function inforEmployee(Request $request){
        $user = JWTAuth::toUser($request->input('token'));
        try{
            $employee = Employee::where('employee_user_id', $user->id)->first();
            if(empty($employee)){
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
                ],404);
            }
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ],200);
        }catch (JWTException $exception){
            return response()->json([
                'status' => 404,
                'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
            ],404);
        }
    }
}
