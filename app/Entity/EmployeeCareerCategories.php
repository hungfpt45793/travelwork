<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployeeCareerCategories extends Model
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
}
