<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category_price extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'category_price';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_id',
        'category_name',
        'category_slug',
        'category_image',
        'category_content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
