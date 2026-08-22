<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Statistical_employees extends Model
{
    protected $table = 'statistical_employees';
    protected $primaryKey = 'id_statistical';
    protected $fillable = [
        'id_statistical',
        'employees_id',
        'money',
        'total_teacher',
        'total_exam',
        'total__dowload_voucher',
        'total_view_voucher',
        'total_view_job',
        'total_cv',
        'created_at',
        'updated_at'
    ];

}
