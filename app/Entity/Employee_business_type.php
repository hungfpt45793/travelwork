<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_business_type extends Model
{
    protected $table = 'employee_business_type';
    protected $primaryKey = 'employee_business_type_id';
    protected $fillable = [
        'employee_business_type_id',
        'employee_id',
        'business_type_id',
        'created_at',
        'updated_at'
    ];

    public static function get_array_business_id($employee_id)
    {
        $list_carrer = Employee_business_type::select('business_type_id')
            ->where('employee_id', $employee_id)
            ->get();
        $carrer = array();
        if (!empty($carrer)) {
            return $carrer;
        }
        foreach ($list_carrer as $car) {
            $carrer[] = $car->business_type_id;
        }
        return $carrer;
    }

    public static function get_array_name($employee_id)
    {
        $list_business = Employee_business_type::select('business_type.business_type_name')
            ->join('business_type','business_type.business_type_id','employee_business_type.business_type_id')
            ->where('employee_business_type.employee_id', $employee_id)
            ->distinct()
            ->get();
        return $list_business;
    }
}
