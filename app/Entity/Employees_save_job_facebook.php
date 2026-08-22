<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employees_save_job_facebook extends Model
{
    protected $table = 'employees_save_job_facebook';
    protected $primaryKey = 'save_job_fb_id';
    protected $fillable = [
        'save_job_fb_id ',
        'employee_id',
        'id_job_fb',
        'status_job',
        'created_at',
        'updated_at',
    ];

    public static function checkSaveJobFacebook($employee_id,$id_job_fb,$status_job)
    {
        $save_job_fb = new Employees_save_job_facebook();
        $count_save = $save_job_fb->where('id_job_fb',$id_job_fb)
            ->where('employee_id', $employee_id)
            ->where('status_job',$status_job)
            ->count();
        return $count_save;
    }
    public static function get_total_employee($employee_id)
    {
        $total = Employees_save_job_facebook::where('employee_id',$employee_id)
            ->count();
        return  $total;
    }
}

