<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Employee_intro_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'employee_intro_employer';
    protected $primaryKey = 'intro_id';
    protected $fillable = [
        'intro_id',
        'user_id',
        'employer_id',
        'status_intro',
        'money_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function sum_total_money_employee($user_id)
    {
        $sum_employee = Employee_intro_employer::select('money_status')
            ->where('user_id',$user_id)->sum('money_status');
        return $sum_employee;
    }
}
