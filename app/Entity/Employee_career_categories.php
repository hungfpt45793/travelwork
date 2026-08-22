<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_career_categories extends Model
{
    protected $table = 'employee_career_categories';
    protected $primaryKey = 'employee_career_category_id';
    protected $fillable = [
        'employee_career_category_id',
        'employee_id',
        'career_category_id',
        'created_at',
        'updated_at'
    ];

    public static function get_array_career_id($employee_id)
    {
        $list_carrer = Employee_career_categories::select('career_category_id')
            ->where('employee_id', $employee_id)
            ->get();
        $carrer = array();
        if (!empty($carrer)) {
            return $carrer;
        }
        foreach ($list_carrer as $car) {
            $carrer[] = $car->career_category_id;
        }
        return $carrer;
    }
    public static function get_career_id($employee_id)
    {
        $list_carrer = Employee_career_categories::select('career_category_id')
            ->where('employee_id', $employee_id)
            ->first();
        return $list_carrer;
    }
    public static function get_array_name($employee_id)
    {
        $list_carrer = Employee_career_categories::select('career_categories.career_category_id','career_categories.career_category_name')
            ->join('career_categories','career_categories.career_category_id','employee_career_categories.career_category_id')
            ->where('employee_career_categories.employee_id', $employee_id)
            ->distinct()
            ->get();
        return $list_carrer;
    }

    public static function get_coin_view_profile($employee_id)
    {
        $list_carrer = Employee_career_categories::select('career_categories.view_profile')
            ->join('career_categories','career_categories.career_category_id','employee_career_categories.career_category_id')
            ->where('employee_career_categories.employee_id', $employee_id)
            ->get()->toArray();
        $array_view_profile = [];
        foreach($list_carrer as $carrer){
            array_push($array_view_profile, $carrer['view_profile']);
        }
        return !empty($array_view_profile) ? max($array_view_profile) : 1;
    }

//    public static function coin_view_profile($employee_id)
//    {
//        $list_carrer = Employee_career_categories::select('career_categories.view_profile')
//            ->join('career_categories','career_categories.career_category_id','employee_career_categories.career_category_id')
//            ->where('employee_career_categories.employee_id', $employee_id)
//            ->get()->toArray();
//
//        $array_view_profile = [];
//        foreach($list_carrer as $carrer){
//            array_push($array_view_profile, $carrer['view_profile']);
//        }
//        return !empty($array_view_profile) ? max($array_view_profile) : 0;
//
//
//    }

}
