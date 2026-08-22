<?php

namespace App\Http\Controllers\Api;

use App\Entity\Career;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\Province;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class JobUserSubmitController extends Controller
{
    public function get_job_file_submit(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $employee = Employee::select('*')->where('user_id', $user->id)->first();
        //công việc thực tập
        //công viêc đã kiểm duyệt
        $jobs = $this->EmployeeSubmitJob($user->id, 1);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách công việc đã nộp hồ sơ',
            'jobs' => $jobs,
        ], 200);

    }
    public function EmployeeSubmitJob($user_id, $status_job)
    {
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at','jobs.active_job',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                'employer.enterprise_name','employer.employer_id','province.province_name','district.district_name'
            )
            ->leftJoin('employer','employer.employer_id','=','jobs.employer_id')
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district')
            ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', 'jobs.job_id');
//        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('employee_submit_job_facebook.employee_id', $emplo->employee_id);
        $list_jobs = $list_jobs->where('employee_submit_job_facebook.status_job', $status_job);
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
//        $total = $list_jobs->count();
        $list_jobs =  $list_jobs->paginate(10);
        return $list_jobs;
    }


}

