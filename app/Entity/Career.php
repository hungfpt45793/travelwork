<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'career_categories';
    protected $primaryKey = 'career_category_id';
    protected $fillable = [
        'career_category_id',
        'career_category_name',
        'career_category_slug',
        'career_category_salary', //trọng số lương
        'description',
        'content',
        'welfare',
        'image',
        'slug',
        'status_show', //0 là măc định hiện còn 1 là ẩn
        'view_profile',
        'view_apply',
        'total_jobs',
        'recruit',
        'recruited',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function get_all_career()
    {
        $ca = new Career();
        $ca = $ca->select('career_category_id', 'career_category_name', 'career_category_slug')->get();
        return $ca;
    }
    public static function get_all_statu_show()
    {
        $ca = new Career();
        $ca = $ca->select('career_category_id', 'career_category_name', 'career_category_slug')
            ->where('status_show',0)
            ->get();
        return $ca;
    }

    public static function getAllCareer()
    {
        $ca = new Career();
        $ca = $ca->select('*')->get();
        return $ca;
    }

    public static function getIdCareer($id)
    {
        $ca = new Career();
        $ca = $ca->select('*')->where('career_category_id', $id)->first();
        return $ca;
    }

    public static function getSlugCareer($slug)
    {
        $ca = new Career();
        $ca = $ca->select('*')->where('career_category_slug', 'like', '%' . $slug . '%')->first();
        return $ca;
    }

    public static function get_total_carrer_id($career_category_id)
    {
        $ca = new Career();
        $ca = $ca->select('career_category_id')->where('career_category_id', $career_category_id)->count();
        return $ca;
    }

    public static function check_view_coint($employee_id)
    {
        $ca = new Career();
        $ca = $ca->select('career_categories.career_category_id', 'career_categories.view_profile', 'career_categories.view_apply', 'employees.career_category_id', 'employees.employee_id')
            ->join('employees', 'employees.career_category_id', '=', 'career_categories.career_category_id')
            ->where('employees.employee_id', $employee_id)
            ->first();
        return $ca;
    }

    public static function list_carrer_category_exam()
    {
        $carrer_model = new Career();
        $list_carrer = $carrer_model->select('career_categories.career_category_id',
            'career_categories.career_category_name'
        )
            ->join('exam', 'exam.exam_local_job_id', '=', 'career_categories.career_category_id')
            ->distinct('career_categories.career_category_id')
            ->get();
        return $list_carrer;
    }
}
