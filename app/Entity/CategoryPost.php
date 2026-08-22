<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPost extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'category_post';

    protected $primaryKey = 'category_post_id';

    protected $fillable = [
        'category_post_id',
        'category_id',
        'post_id',
        'tag_post_type',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function post() {
        return $this->hasOne('App\Entity\Post','post_id');
    }
}
