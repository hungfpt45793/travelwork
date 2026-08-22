<?php

namespace App\Entity;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'training';
    protected $primaryKey = 'trai_id';

    protected $fillable = [
        'trai_id',
        'trai_title',
        'trai_slug',
        'course_id', //0 là tất cả đơn hàng
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
