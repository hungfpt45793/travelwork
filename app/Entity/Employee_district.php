<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_district extends Model
{
    protected $table = 'employee_district';
    protected $primaryKey = 'employee_district_id';
    protected $fillable = [
        'employee_district_id',
        'employee_id',
        'district_id',
        'created_at',
        'updated_at'
    ];
    public static function get_array_district_id($employee_id)
    {
        $list_carrer = Employee_district::select('district_id')
            ->where('employee_id', $employee_id)
            ->get();
        $carrer = array();
        if (!empty($carrer)) {
            return $carrer;
        }
        foreach ($list_carrer as $car) {
            $carrer[] = $car->district_id;
        }
        return $carrer;
    }

    public static function get_district_name($employee_id)
    {
        $list_district_name = Employee_district::select('district.district_name')
            ->join('district','district.district_id','=','employee_district.district_id')
            ->where('employee_district.employee_id',$employee_id)
            ->distinct()
            ->get();
        return $list_district_name;
    }
}

