<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Office_information extends Model
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'office_information';
    protected $primaryKey = 'office_id';
    public $timestamps = false;
    protected $fillable = [
        'office_id',
        'office_name',
        'office_give',
        'office_slug',
        'office_salary', //trọng số lương
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
