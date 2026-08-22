<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_follow_employer extends Model
{
    protected $table = 'employee_follow_employer';
    protected $primaryKey = 'id_follow';
    protected $fillable = [
        'id_follow',
        'employee_id',
        'employer_id',
        'created_at',
        'updated_at',
    ];

    public static function check_employee_follow_employer($employee_id,$employer_id)
    {
        $check = Employee_follow_employer::select('*')
            ->where('employee_id',$employee_id)
            ->where('employer_id',$employer_id)
            ->count();
        return $check;
    }
    public static function total_follow_employee($employee_id)
    {
        $list_employer = Employee_follow_employer::where('employee_id',$employee_id)->get();
        $employer_id = array();
        foreach ($list_employer as $employer)
        {
            $employer_id[] = $employer['employer_id'];
        }
        $job = new Job();
        $total_job = $job->whereIn('employer_id',$employer_id)
            ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
            ->count();
//        echo'<pre>';
//        print_r($employer_id);
//        echo '</pre>';
//        print_r($total_job);die();
        return $total_job;
    }
    public static function total_follow_employer($employer_id)
    {
        $total_employer = Employee_follow_employer::where('employer_id',$employer_id)->count();
        return $total_employer;
    }
}
