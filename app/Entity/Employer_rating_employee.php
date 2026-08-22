<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entity\EmployeeActiveCv;
use PDFMerger;

class Employer_rating_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'employer_rating_employee';
    protected $primaryKey = 'employer_rating_id';
    protected $fillable = [
        'employer_rating_id',
        'employer_id',
        'employee_id',
        'rating_start',
        'rating_content',
        'status_rating_employee',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
