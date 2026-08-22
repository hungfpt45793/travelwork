<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];


    protected $table = 'jobs';
    protected $primaryKey = 'job_id';
    public $timestamps = false;
    protected $fillable = [
        'job_id',
        'job_code',
        'vip',  //1 - víp 1 yes, 2 là víp 2 , 0 - no
        'views',
        'status',
        'employer_id',
        'experience_id',
        'literacy_id',
        'deadline_submit_profile',
        'number_recruit',
        'province',
        'district',
        'address_work',
        'salary_id',
        'age_id',
        'gender',  //	giới tính tuyển
        'content',
        'sale_package_id',
        'slug',
        'description',
        'tags',
        'created_at',
        'updated_at',
        'deleted_at',
        'people_seen',
        'date_submit',
        'title',
        'date_end',
        'jobgroup_id',
        'career_category_id',
        'status_exam',
        'id_exam',
        'date_exam_job',
        'software_id',
        'welfare',
        'count_updated_at',
        'active_job',
        'sale_money',
        'user_id',
        'day_handling',
        'status_select_job', //0 là tin tuyển dụng bt, 1 là tuyển dụng tuyển hộ , 2 là tin của đơn hàng' AFTER `day_handling
        'email_to_profile' //email nhận hồ sơ nếu k nhập thì mặc định gửi email
//       'image',
//       'image_list'
//       'approved',// 'number_recruited',
//        'applicants',
//        'position',
//        'meta_title',
//        'meta_description',
//        'meta_keyword',
//        'campain_candidate',
//        'user_id_candidate',
//        'campain_status',
//       'price_min',

    ];

    public static function total_carerr_job($career_category_id)
    {
        $postModel = new Job();
        $total_post = $postModel->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $total_post = $total_post->where('jobs.active_job', 1);
        $total_post = $total_post->where('career_category_id', $career_category_id)->count();

        $total_job_fb = JobFacebook::whereDate('job_facebook.date_end', '>=', date('Y-m-d'))
            ->where('career_category_id', $career_category_id)
            ->count();
        $total = $total_post + $total_job_fb;
        return $total;
    }

    public static function get_post_id($job_id)
    {
        $postModel = new Job();
        $post = $postModel->select(
            'job_id',
            'status',
            'deadline_submit_profile',
            'slug',
            'description',
            'created_at',
            'updated_at',
            'deleted_at',
            'date_submit',
            'title',
            'applicants',
            'status_exam',
            'active_job',
            'sale_money')->where('job_id', $job_id)->first();
        return $post;
    }

    public static function get_post_slug($job_id)
    {
        $postModel = new Job();
        $post = $postModel->select(
            'job_id',
            'slug')->where('job_id', $job_id)->first();
        return $post;
    }

    public static function get_post_id_slug($slug)
    {
        $postModel = new Job();
        $post = $postModel->where('slug', $slug)->value('job_id');
        return $post;
    }

    public static function getAllJob($litmit)
    {

        $jobEmployer = new Job();
        $Job = $jobEmployer->select('job_id', 'slug', 'title', 'salary_id', 'district', 'province')->limit($litmit)->orderByDesc('job_id')->get();
        return $Job;
    }

    public static function get_status_money($job_id)
    {
        $job = new Job();
        $job = $job->select('sale_money', 'job_id', 'deadline_submit_profile')->where('job_id', $job_id)
            ->where('sale_money', '=', 1)
            ->whereDate('deadline_submit_profile', '>=', date('Y-m-d'))
            ->count();
        return $job;
    }

    public static function showJobVip()
    {
        try {
            $isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                        |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                , $_SERVER["HTTP_USER_AGENT"]);
            if ($isMobile == 1) {
                $limit = 3;
            } else {
                $limit = 9;
            }
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.vip', '>', 0)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobVipLimit($limit)
    {
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.vip', '>', 0)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobVipHome($limit)
    {
//        0 la tin thuong 1 la vip 1 2 la vip 2
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.vip', '=', 1)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.updated_at',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobVip2Home($limit)
    {
//        0 la tin thuong 1 la vip 1 2 la vip 2
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.vip', '!=', 1)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'jobs.updated_at',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.vip', 'desc')
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobVipLimitValue($limit, $value)
    {
//        0 la tin thuong 1 la vip 1 2 la vip 2
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.vip', '=', $value)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobVipLimit_salary($limit, $province_id, $career_category_id)
    {
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->join('career_categories', 'career_categories.career_category_id', 'jobs.career_category_id')
//                ->where('jobs.vip', '>', 0)
                ->where('jobs.province', $province_id)
                ->where('jobs.career_category_id', $career_category_id)
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobNewLimit($limit)
    {
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('jobs.active_job', 1)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->select(
                    'jobs.slug',
                    'jobs.title',
                    'jobs.deadline_submit_profile',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district_name',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit($limit)
                ->get();
            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function showJobNews()
    {
        try {
            $jobs = static::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->select(
                    'jobs.*',
                    'salary.description as salary_description',
                    'province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->limit(12)
                ->get(12);

            return $jobs;
        } catch (\Exception $e) {
            return array();
        }

    }


    public static function showJobWithEmployerId($employer_id, $count = 10)
    {
        try {
            $jobs = static::select(
                'jobs.*',
                'salary.description as salary_description',
                'province_name',
                'district_name'
            )
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->where('employer_id', $employer_id)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->orderByDesc('jobs.job_id')
                ->limit($count)
                ->get();

            return $jobs;
        } catch (\Exception $e) {
            return array();
        }
    }

    public static function getAllJobEmployer($employer_id)
    {
        $jobs = new Job();
        $totalJob = $jobs->select('job_id')->where('employer_id', $employer_id)->count();
        return $totalJob;
    }

    public static function getJobEmployer($employer_id)
    {
        $jobs = new Job();
        $jobs = $jobs->select('slug', 'job_id', 'title')->where('employer_id', $employer_id)->get();
        return $jobs;
    }


    public static function total_job_employer($employer_id)
    {
        $jobs = new Job();
        $totalJob = $jobs->select('job_id')->where('employer_id', $employer_id)->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))->count();
        return $totalJob;
    }

    public static function sidebar_job($limit)
    {
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.active_job', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province'
            );
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        //tong so bai viet
        $total_jobs = $list_jobs->count();
        $list_jobs = $list_jobs->limit($limit)->get();
        return $list_jobs;
    }

    //tông số công việc theo ngành nghề
    public static function get_total_career($career_category_id)
    {
        $jobModel = new Job();
        $total_job = $jobModel->whereDate('deadline_submit_profile', '>=', date('Y-m-d'))
            ->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }

    public static function get_total_province($province)
    {
        $jobModel = new Job();
        $total_job = $jobModel->whereDate('deadline_submit_profile', '>=', date('Y-m-d'))
            ->count();
        if (empty($total_job)) {
            $total_job = 0;
        }
        return $total_job;
    }

    public static function get_total_career_province_id($career_category_id, $province_id, $district_id)
    {
        $jobModel = new Job();
        $total_job = $jobModel->select('career_category_id', 'deadline_submit_profile');
        $total_job = $total_job->where('career_category_id', $career_category_id);
        $total_job = $total_job->whereDate('deadline_submit_profile', '>=', date('Y-m-d'));
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
        $jobModel = new Job();
        $total_job = $jobModel->select('career_category_id', 'deadline_submit_profile');
        $total_job = $total_job->where('salary_id', $salary_id);
        $total_job = $total_job->whereDate('deadline_submit_profile', '>=', date('Y-m-d'));
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
        $jobModel = new Job();
        $total_job = $jobModel->select('career_category_id', 'deadline_submit_profile');
        if (!empty($date_form)) {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
            $total_job = $total_job->whereDate('updated_at', '>=', $date_form);
            $total_job = $total_job->whereDate('updated_at', '<=', date('Y-m-d'));
        }
        $total_job = $total_job->whereDate('deadline_submit_profile', '>=', date('Y-m-d'));

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

    // lấy thông tin tag của job
    public static function all_job_tags($job_id)
    {
        $tags = Job::select('tags')
            ->where('job_id', $job_id)
            ->get();
        return $tags;
    }

    public static function get_employer_job($employer_id)
    {
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->join('career_categories', 'career_categories.career_category_id', '=', 'jobs.career_category_id')
            ->select(
                'jobs.title', 'jobs.job_code', 'jobs.job_id', 'jobs.views', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job', 'career_categories.view_apply'
            );
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('employer_id', $employer_id);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');

        $list_jobs = $list_jobs->limit(20)
            ->get();
        return $list_jobs;
    }

    public static function count_employer_job($employer_id)
    {
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->join('career_categories', 'career_categories.career_category_id', '=', 'jobs.career_category_id')
            ->select(
                'jobs.title', 'jobs.job_code', 'jobs.job_id', 'jobs.views', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job', 'career_categories.view_apply'
            );
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('employer_id', $employer_id);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');

        $list_jobs = $list_jobs->count();
        return $list_jobs;
    }

}
