<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class CategoriesJoinExam extends Model
{
    protected $table = 'categories_join_exam';
    protected $primaryKey = 'id_cate_join_exam';
    protected $fillable = [
        'id_cate_join_exam',
        'id_categories_exam',
        'id_exam',
        'created_at',
        'updated_at',
    ];
}
