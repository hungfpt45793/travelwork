<?php

namespace App\Http\Controllers\Api;

use App\Entity\Job;
use App\Entity\Province;
use App\Entity\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class JobController extends Controller
{
    public function getAllJob(Request $request){
        $jobs = Job::leftJoin('employer', 'employer.employer_id','=','jobs.job_id')
            ->leftJoin('salary','salary.salary_id','=','jobs.salary_id')
            ->select(
                'jobs.job_id',
                'jobs.position',
                'salary.description',
                'employer.enterprise_name',
                'employer.image'
            )
            ->paginate(20);

        if(empty($jobs)){
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ]);
        }
        return response([
            'status' => 200,
            'jobs' => $jobs
        ]);
    }

    public function getAllProvince(){
        $provinces = Province::paginate(10);
        return response()->json([
            'status' => 200,
            'provinces' => $provinces
        ]);
    }

    public function getAllSalary(){
        $salaries = Salary::paginate(10);
        return response()->json([
            'status' => 200,
            'salaries' => $salaries
        ]);
    }

    public function detailJob(Request $request, $jobID){
        $job = Job::leftJoin('job_career_categories', 'job_career_categories.job_id','=','jobs.job_id')
            ->leftJoin('career_categories','career_categories.career_category_id','=','job_career_categories.career_category_id')
            ->leftJoin('job_jobgroup','job_jobgroup.job_id', '=','jobs.job_id')
            ->leftJoin('job_group','job_group.job_group_id','=','job_jobgroup.job_group_id')
            ->leftJoin('employer','employer.employer_id','=','jobs.employer_id')
            ->where('jobs.job_id',$jobID)
            ->first();

        if (empty($job)){
            return response()->json([
                'status' => 404,
               'message' => 'Công việc không tồn tại hoặc đã bị xóa',
            ]);
        }
        return response([
           'status' => 200,
           'job' => $job
        ],200);
    }

    public function search(Request $request){
        try{
            $salary = $request->input('salary');
            $province = $request->input('province');
            $job = $request->input('job');

            $jobs = Job::leftJoin('job_career_categories', 'job_career_categories.job_id','=','jobs.job_id')
                ->leftJoin('career_categories','career_categories.career_category_id','=','job_career_categories.career_category_id')
                ->leftJoin('job_jobgroup','job_jobgroup.job_id', '=','jobs.job_id')
                ->leftJoin('job_group','job_group.job_group_id','=','job_jobgroup.job_group_id')
                ->leftJoin('employer','employer.employer_id','=','jobs.employer_id');

            if(!empty($salary)){
                $jobs = $jobs->where('jobs.salary_id', $salary);
            }

            if(!empty($province)){
                $jobs = $jobs->where('jobs.province', $province);
            }

            if(!empty($job)){
                $jobs = $jobs->where('jobs.job_id', $job);
            }

            $jobs = $jobs->paginate(10)->appends(['salary' => $salary, 'province'=> $province, 'job' => $job]);

            if(empty($jobs)){
                return response()->json([
                    'status' => 404,
                    'message' => 'Không có công việc nào bạn cần tìm.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'jobs' => $jobs
            ]);
        }catch (JWTException $exception){
            return response()->json([
                'status' => 404,
                'message' => 'Đã có lỗi xảy ra'
            ]);
        }

    }
}
