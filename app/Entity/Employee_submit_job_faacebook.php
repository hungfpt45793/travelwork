<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_submit_job_faacebook extends Model
{
    protected $table = 'employee_submit_job_facebook';
    protected $primaryKey = 'submit_job_fb_id';
    protected $fillable = [
        'submit_job_fb_id ',
        'employee_id',
        'id_job_fb',
        'status_job',//0 đề thi facebook ; 1 là đi thi tuyển dụn
        'status_show_cv',//	0 là ứng tuyển nhanh chờ xác thực email hoặc nhanvien duyệt tài khoản , 1 là tìa khoản nộp hồ sơ bình thường ; mặc định = 1
        'status_apply_cv',//		0 là nộp cv 1 là ứng tuyển nhanh
        'id_status_submit_job', //trang thai ho so
        'status_change_profile', //0 là hố sơ ứng viên tự nộp , 1 là trường hợp nhân viên nộp hồ sơ hộ
        'day_submit_job', //	ngày nộp hồ sơ
        'status_syll',
        'job_app_content',
        'created_at',
        'updated_at'
    ];

    public static function checkSubmitJobFacebook($employee_id, $id_job_fb, $status_job)
    {
        $submit_job_fb = new Employee_submit_job_faacebook();
        $count_save = $submit_job_fb->where('id_job_fb', $id_job_fb)
            ->where('employee_id', $employee_id)
            ->where('status_job', $status_job)
            ->count();
        return $count_save;
    }
    public static function check_apply_cv()
    {
        $submit_job_fb = new Employee_submit_job_faacebook();
        $list_employees= $submit_job_fb->select(
            'employee_submit_job_facebook.submit_job_fb_id',
            'employee_submit_job_facebook.employee_id',
            'employee_submit_job_facebook.id_job_fb',
            'employee_submit_job_facebook.status_job',//0 đề thi facebook ; 1 là đi thi tuyển dụn
            'employee_submit_job_facebook.status_show_cv',//	0 là ứng tuyển nhanh chờ xác thực email hoặc nhanvien duyệt tài khoản , 1 là tìa khoản nộp hồ sơ bình thường ; mặc định = 1
            'employee_submit_job_facebook.id_status_submit_job', //trang thai ho so
            'employee_submit_job_facebook.status_change_profile', //0 là hố sơ ứng viên tự nộp , 1 là trường hợp nhân viên nộp hồ sơ hộ
            'employee_submit_job_facebook.day_submit_job', //	ngày nộp hồ sơ
            'employee_submit_job_facebook.status_syll',
            'employee_submit_job_facebook.job_app_content',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.phone',
            'employees.email',
            'jobs.title',
            'jobs.slug',
            'employee_submit_job_facebook.created_at',
            'employee_upload_cv.employee_link_cv',
            'employee_upload_cv.employee_link_html'
        )
            ->join('jobs','jobs.job_id','=','employee_submit_job_facebook.id_job_fb')
            ->join('employees','employees.employee_id','=','employee_submit_job_facebook.employee_id')
            ->join('employee_upload_cv','employee_upload_cv.employee_id','=','employees.employee_id')
            ->where('employee_submit_job_facebook.status_apply_cv', 1)
            ->count();
        return $list_employees;
    }

    public static function getTotalsubmitJon($id_job_fb, $status_job)
    {
        $submit_job_fb = new Employee_submit_job_faacebook();
        $count_save = $submit_job_fb
            ->where('id_job_fb', $id_job_fb)
            ->where('status_job', $status_job)
            ->count();
        return $count_save;
    }public static function getTotalsubmitJonCV($id_job_fb, $status_job)
    {
        $submit_job_fb = new Employee_submit_job_faacebook();
        $count_save = $submit_job_fb
            ->where('id_job_fb', $id_job_fb)
            ->where('status_job', $status_job)
            ->where('status_show_cv', 1)
            ->count();
        return $count_save;
    }

    //trạng thái hồ sơ
    public static function getTotalStatusJob($job_id, $id_status_submit_job)
    {

        $submit_job_fb = new Employee_submit_job_faacebook();
        $count_status = $submit_job_fb->select('id_status_submit_job', 'id_job_fb', 'status_job');
        $count_status = $count_status->where('id_status_submit_job', $id_status_submit_job);
        $count_status = $count_status->where('status_job', 1);
        if (is_array($job_id)) {
            $count_status = $count_status->whereIn('id_job_fb', $job_id);
        } else {
            $count_status = $count_status->where('id_job_fb', $job_id);
        }

        $count_status = $count_status->count();
        return $count_status;
    }public static function getTotalStatusJobCV($job_id, $id_status_submit_job)
    {

        $submit_job_fb = new Employee_submit_job_faacebook();
        $count_status = $submit_job_fb->select('id_status_submit_job', 'id_job_fb', 'status_job');
        $count_status = $count_status->where('id_status_submit_job', $id_status_submit_job);
        $count_status = $count_status->where('status_job', 1);
        $count_status = $count_status->where('status_show_cv', 1);
        if (is_array($job_id)) {
            $count_status = $count_status->whereIn('id_job_fb', $job_id);
        } else {
            $count_status = $count_status->where('id_job_fb', $job_id);
        }

        $count_status = $count_status->count();
        return $count_status;
    }
    public static function get_total_employer_submit($employee_id)
    {
        $total_employee = Employee_submit_job_faacebook::where('employee_id',$employee_id)
            ->count();
        return $total_employee;
    }
}
