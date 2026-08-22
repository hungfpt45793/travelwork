<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_apply_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'coin_apply_employee';
    protected $primaryKey = 'coin_apply';
    protected $fillable = [
        'coin_history_id',
        'employer_id',
        'employee_id',
        'job_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function check_employer_contact_employee($employer_id,$employee_id)
    {
        $coin_show_employee = Coin_apply_employee::select('employee_id','employer_id','created_at')
            ->where('employer_id',$employer_id)
            ->where('employee_id',$employee_id)
            ->orderBy('coin_history_id','desc')
            ->first();
        return $coin_show_employee;
    }
    public static function check_employer_contact_job_employee($employer_id,$employee_id,$job_id)
    {
        $coin_show_employee = Coin_apply_employee::select('employee_id','employer_id','created_at','job_id')
            ->where('employer_id',$employer_id)
            ->where('employee_id',$employee_id)
            ->where('job_id',$job_id)
            ->orderBy('coin_history_id','desc')
            ->first();
        return $coin_show_employee;
    }

}
