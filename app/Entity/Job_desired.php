<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job_desired extends Model
{
    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'job_desired';
    protected $primaryKey = 'job_de_id';
    public $timestamps = false;
    protected $fillable = [
        'job_de_id',
        'employee_id',
        'province_id',
        'district_id',
        'salary_id',
        'career_category_id',
        'date_create',
        'software_id',
        'created_at',
        'updated_at',

    ];
    public static function total_desired($user_id)
    {
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();

        $jobs_desired = Job_desired::select('*')->where('employee_id', $emplo->employee_id)->first();
        if (empty($jobs_desired)) {
            $list_jobs = array();
            $list_job_fb = array();
            $total_jobs = 0;
            $total_job_fb = 0;
            $total = 0;
        } else {
            $jobs_model = new Job();
            $list_jobs = $jobs_model
                ->join('salary', 'salary.salary_id', 'jobs.salary_id')
                ->select(
                    'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.province', 'jobs.career_category_id', 'jobs.salary_id', 'jobs.district',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile'
                );
            if (!empty($jobs_desired->province_id)) {
                $list_jobs = $list_jobs->where('jobs.province', $jobs_desired->province_id);
            }
            if (!empty($jobs_desired->district_id)) {
                $list_jobs = $list_jobs->where('jobs.district', $jobs_desired->district_id);
            }
            if (!empty($jobs_desired->salary_id)) {

                $array_salary_id = explode(',', $jobs_desired->salary_id);
                $list_jobs = $list_jobs->whereIn('jobs.salary_id', $array_salary_id);
            }
            if (!empty($jobs_desired->career_category_id)) {
                $array_career_category_id = explode(',', $jobs_desired->career_category_id);
                $list_jobs = $list_jobs->where('jobs.career_category_id', $array_career_category_id);
            }

            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            //tong so bai viet
            $total_jobs = $list_jobs->count();


            $jobfaceModule = new JobFacebook();
//        sắp xếp theo tin mới nhất
            $list_job_fb = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
            $list_job_fb->select('salary.description as salary_description', 'job_facebook.*');
            if (!empty($jobs_desired->province_id)) {
                $list_job_fb = $list_job_fb->where('job_facebook.province', $jobs_desired->province_id);
            }
            if (!empty($jobs_desired->district_id)) {
                $list_job_fb = $list_job_fb->where('job_facebook.district', $jobs_desired->district_id);
            }
            if (!empty($jobs_desired->salary_id)) {

                $array_salary_id = explode(',', $jobs_desired->salary_id);
                $list_job_fb = $list_job_fb->whereIn('job_facebook.salary_id', $array_salary_id);
            }
            if (!empty($jobs_desired->career_category_id)) {
                $array_career_category_id = explode(',', $jobs_desired->career_category_id);
                $list_job_fb = $list_job_fb->where('job_facebook.career_category_id', $array_career_category_id);
            }

            $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
            $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
            $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
            $list_job_fb = $list_job_fb->orderBy('job_facebook.job_facebook_id', 'desc');
            $total_job_fb = $list_job_fb->count();

            $total = $total_jobs + $total_job_fb;
            return $total;
        }
    }

}
