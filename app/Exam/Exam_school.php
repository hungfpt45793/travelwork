<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Exam_school extends Model
{

    protected $table = 'exam_school';
    protected $primaryKey = 'id_exam';
    protected $fillable = [
        'id_exam',
        'code_exam',
        'name_exam',
        'intro_exam',
        'time_exam',
        'id_class_school',
        'teacher_sc_id',
        'created_at',
        'updated_at',
    ];
    public static function getExam($id_exam)
    {
        $exam = new Exam_school();
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
