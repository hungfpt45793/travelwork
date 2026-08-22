<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Educate_employees_class extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'educate_employees_class';
    protected $primaryKey = 'edu_emplo_id';
    public $timestamps = false;
    protected $fillable = [
        'edu_emplo_id',
        'edu_class_id',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static  function get_total_employee_class($edu_class_id)
    {
        $total = Educate_employees_class::where('edu_class_id',$edu_class_id)->count();
        return $total;
    }
    public static  function get_employee_class($edu_class_id,$employee_id)
    {
        $total = Educate_employees_class::where('edu_class_id',$edu_class_id)
            ->where('employee_id',$employee_id)
            ->first();
        return $total;
    }
}
