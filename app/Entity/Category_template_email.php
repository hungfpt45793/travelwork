<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category_template_email extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'category_template_email';

    protected $primaryKey = 'id_cate_tem';

    protected $fillable = [
        'id_cate_tem',
        'name_cate_tem',
        'slug_cate_tem',
        'note_tem_var',
        'created_at',
        'updated_at'
    ];


}
