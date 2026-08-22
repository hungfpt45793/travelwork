<?php

namespace App\Entity;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFacebook extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'job_facebook';
    protected $primaryKey = 'job_facebook_id';

    protected $fillable = [
        'job_facebook_id',
        'job_facebook_code',
        'title',
        'des_facebook',
        'content',
        'slug',
        'link',
        'phone',
        'email',
        'address',
        'salary_id',
        'province',
        'code',
        'career_category_id',
        'careers',
        'view',
        'district',
        'date_end',
        'warning_job_fb',
        'user_warning',
        'user_id',
        'employer_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'job_info_contact',
        'vip',
//        'welfare',
        'company_name',
        'number_recruit',
        'created_at',
    ];
    public static function get_total_job_facebook_email($email)
    {
        $jobfaceboook = new JobFacebook();
        $totalJobfacebook = $jobfaceboook->select('job_facebook_id')->where('email', $email)->count();
        return $totalJobfacebook;
    }

    public static function getAllJobFacebookEmployer($employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $totalJobfacebook = $jobfaceboook->select('job_facebook_id')->where('employer_id', $employer_id)->count();
        return $totalJobfacebook;
    }

    public static function getAllFacebook($litmit)
    {

        $jobfaceboook = new JobFacebook();
        $Jobfacebook = $jobfaceboook->select('job_facebook_id', 'slug', 'title', 'salary_id', 'district', 'province')->limit($litmit)->orderByDesc('job_facebook_id')->get();
        return $Jobfacebook;
    }

    public static function getDayAllFacebook($employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $totalJobfacebook = $jobfaceboook->select('job_facebook_id')->whereDate('created_at', date('Y/m/d'))->where('employer_id', $employer_id)->count();
        return $totalJobfacebook;
    }

    public static function getMonthAllFacebook($employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $totalJobfacebook = $jobfaceboook->select('job_facebook_id')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('employer_id', $employer_id)->count();
        return $totalJobfacebook;
//        if (!empty($request->input('star_time')) && !empty($request->input('end_time')) && $request->input('end_time') != '0000-00-00') {
//            $star_time = $request->input('star_time');
//            $end_time = $request->input('end_time');
////            $supports = $supports->whereBetween('ho_tro_khach_hang.ngay_ht', [$star_time, $end_time]);
//            $supports = $supports->whereDate('ho_tro_khach_hang.ngay_ht', '>=', $star_time);
//            $supports = $supports->whereDate('ho_tro_khach_hang.ngay_ht', '<=', $end_time);
//        } else {
//            $supports = $supports->whereDate('ho_tro_khach_hang.ngay_ht', '=', $date);
//        }
    }

    public static function getBetweenAllFacebook($star_time, $end_time, $employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $totalJobfacebook = $jobfaceboook->select('job_facebook_id')
            ->whereDate('created_at', '>=', $star_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('employer_id', $employer_id)
            ->count();
        return $totalJobfacebook;
    }

    public static function sidebar_job_fb($limit)
    {
        $jobFb_model = new JobFacebook();
        $list_job_fb = $jobFb_model->select(
            'job_facebook.*',
            'salary.description as salary_description', 'salary.salary_id'
        );
        $list_job_fb = $list_job_fb->join('salary', 'salary.salary_id', 'job_facebook.salary_id');
        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
        $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
        $list_job_fb = $list_job_fb->limit($limit)->get();
        return $list_job_fb;
    }

    public static function get_total_career($career_category_id)
    {
        $jobFb_model = new JobFacebook();
        $total_job = $jobFb_model->whereDate('date_end', '>=', date('Y-m-d'))
            ->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }



    public static function get_total_province($province)
    {
        $jobFb_model = new JobFacebook();
        $total_job = $jobFb_model->whereDate('date_end', '>=', date('Y-m-d'))
            ->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }
    public static function get_total_career_province($career_category_id, $province_id, $district_id)
    {
        $jobFb_model = new JobFacebook();
        $total_job = $jobFb_model->select('career_category_id', 'date_end')
            ->where('career_category_id', $career_category_id);
        $total_job = $total_job->whereDate('date_end', '>=', date('Y-m-d'));
        if (!empty($province_id)) {
            $total_job = $total_job->where('province', $province_id);
        }
        if (!empty($district_id)) {
            $total_job = $total_job->where('district', $district_id);
        }
        $total_job = $total_job->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }
    public static function get_total_salary_id($salary_id, $province_id, $district_id)
    {
        $jobFb_model = new JobFacebook();
        $total_job = $jobFb_model->select('career_category_id', 'date_end')
            ->where('salary_id', $salary_id);
        $total_job = $total_job->whereDate('date_end', '>=', date('Y-m-d'));
        if (!empty($province_id)) {
            $total_job = $total_job->where('province', $province_id);
        }
        if (!empty($district_id)) {
            $total_job = $total_job->where('district', $district_id);
        }
        $total_job = $total_job->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }
    public static function get_total_date($date_form, $province_id, $district_id)
    {
        $date_to = date("Y-m-d");
        $jobFb_model = new JobFacebook();
        $total_job = $jobFb_model->select('career_category_id', 'date_end');
        if(!empty($date_form))
        {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));

            $total_job = $total_job->whereDate('updated_at', '>=',$date_form);
            $total_job = $total_job->whereDate('updated_at', '<=', date('Y-m-d'));
        }

        $total_job = $total_job->whereDate('date_end', '>=', date('Y-m-d'));
        if (!empty($province_id)) {
            $total_job = $total_job->where('province', $province_id);
        }
        if (!empty($district_id)) {
            $total_job = $total_job->where('district', $district_id);
        }
        $total_job = $total_job->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }

}
