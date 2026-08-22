<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $table = 'exam';
    protected $primaryKey = 'id_exam';
    protected $fillable = [
        'id_exam',
        'code_exam',
        'name_exam',
        'slug_exam',
        'image_exam',
        'intro_exam',
        'content_exam',
        'id_cate_exam',
        'id_topic',
        'time_exam',
        'level_exam',
        'create_exam',
        'update_exam',
        'status_exam', //0 la khong thi thu : 1 la thi thu
        'active_exam',
        'view_exam',
        'id_user',
        'is_ques',
        'bank_exam', //0 la khong phai ngan hang 1 la  ngan hang de thi
        'exam_type_id', //loại hình doanh nghiêp
        'exam_local_job_id', //vị trí công việc
        'created_at',
        'updated_at',
    ];
    public static function getExam($id_exam)
    {
        $exam = new Exam();
        $exam = $exam->select('*')->where('id_exam',$id_exam)->first();
        return $exam;
    }
    public static  function checkCategory_Exam($id_exam)
    {
        $category_name = array();
        $categories_exam = CategoriesExam::select('*')
            ->join('categories_join_exam', 'categories_join_exam.id_categories_exam', '=', 'categories_exam.id_cate_exam')
            ->where('categories_exam.parent_cate_exam' ,'=',0)
            ->where('categories_join_exam.id_exam' ,'=',$id_exam)
            ->get();
        if(empty($categories_exam))
        {
            return $category_name;
        }
        $cateChilrens = CategoriesExam::select('*')
            ->join('categories_join_exam', 'categories_join_exam.id_categories_exam', '=', 'categories_exam.id_cate_exam')
            ->where('categories_exam.parent_cate_exam' ,'!=',0)
            ->where('categories_join_exam.id_exam' ,'=',$id_exam)
            ->get();
        if(!empty($cateChilrens))
        {
            foreach($cateChilrens as $id_categories=>$cateChilren)
            {
                $category_name[$id_categories]['name'] = $cateChilren['name_cate_exam'];
                $category_name[$id_categories]['id'] = $cateChilren['id_cate_exam'];
            }
        }
        else
        {
            foreach($categories_exam as $id_categories=>$categories)
            {
                $category_name[$id_categories]['name'] = $categories['name_cate_exam'];
                $category_name[$id_categories]['id'] = $categories['id_cate_exam'];
            }
        }
//        print_r($category_name);die();
        return $category_name;
    }
    public static function getExamID($id)
    {
        $ids = explode(",", $id);
        $exam = Exam::select('*')
            ->whereIn('id_exam', $ids)
            ->get();
        return $exam;
    }
    public static function getCodeExam($id_exam)
    {
        $exam = Exam::select('code_exam','id_exam','name_exam','slug_exam')
            ->where('id_exam', $id_exam)
            ->first();
        return $exam;
    }
}
