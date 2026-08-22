<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class CategoriesExam extends Model
{

    protected $table = 'categories_exam';
    protected $primaryKey = 'id_cate_exam';
    protected $fillable = [
        'id_cate_exam',
        'code_cate_exam',
        'name_cate_exam',
        'slug_cate_exam',
        'parent_cate_exam',
        'image_cate_exam',
        'into_cate_exam',
        'content_cate_exam',
        'icon',
        'location',
        'created_at',
        'updated_at',
    ];
//    lay ve danh muc cha
    public static  function getCategories_exam()
    {
        $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam' ,'=',0)->orderBy('location','asc')->get();
        return $categories_exam;
    }
//    lay ve danh muc con
    public static  function getChilren($id)
    {
        $cateChilren = CategoriesExam::select('*')->where('parent_cate_exam' ,'=',$id)->get();
        return $cateChilren;
    }
    public static function getParent($id)
    {
        $cateChilren = CategoriesExam::select('*')->where('id_cate_exam' ,'=',$id)->first();
        return $cateChilren;
    }
}
