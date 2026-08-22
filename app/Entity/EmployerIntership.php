<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerIntership extends Model
{
    protected $table = 'employer_intership';
    protected $primaryKey = 'intership_id';
    protected $fillable = [
        'intership_id',
        'employer_id',
        'employee_id',
        'status_intership',
        'view_intership',
        'internship_time',
        'id_status',
        'time_star',
        'time_end',
        'des_time',
        'created_at',
        'updated_at',
    ];
    public static function checkIntership($employer_id,$employee_id)
    {
        $employer_inter = new EmployerIntership();
        $intership = $employer_inter->select('*')
            ->where('employer_id',$employer_id)
            ->where('employee_id',$employee_id)->first();
        return $intership;
    }
    public static function totalCvApply($employer_id)
    {
        $employer_inter = new EmployerIntership();
        $total = $employer_inter->select('*')
            ->where('employer_id',$employer_id)
            ->count();
        return $total;
    }
    public static function totalCvSave($employer_id)
    {
        $employer_inter = new EmployerIntership();
        $total = $employer_inter->select('*')
            ->where('employer_id',$employer_id)
            ->where('status_intership',1)
            ->count();
        return $total;
    }
    //trang thai ho so
    public static function getTotalStatus($employer_id,$id_status)
    {
        $employer_inter = new EmployerIntership();
        $total = $employer_inter->select('*')
            ->where('employer_id',$employer_id)
            ->where('id_status',$id_status)
//            ->where('status_intership',1)
            ->count();
        return $total;
    }
    public static function get_total_employee($employee_id)
    {
        $total = EmployerIntership::where('employee_id',$employee_id)
            ->count();
        return $total;
    }
}
