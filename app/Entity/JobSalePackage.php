<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobSalePackage extends Model
{
    protected $table = 'job_sale_package';
    protected $primaryKey = 'job_sale_package_id';
    protected $fillable = [
        'job_sale_package_id',
        'job_id',
        'sale_package_id',
        'recruit',
        'recruited',
        'created_at',
        'updated_at'
    ];
}
