<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category_tag extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    use Rating;

    protected $table = 'category_tag';

    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'tag_type',
        'tag_description',
        'tag_title',
        'tag_keyword',
        'tag_slug',
        'views',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public static function get_tag($tag_title,$tag_type)
    {
        $category_tag = Category_tag::select( 'tag_type',
            'tag_description',
            'tag_title',
            'tag_keyword',
            'tag_slug',
            'views')
            ->where('tag_description','like','%'.$tag_title.'%')
            ->where('tag_type',$tag_type)
            ->get();
        return $category_tag;
    }

    public static function all_tags_post()
    {
        $tags = Category_tag::select('tag_type','tag_title')
            ->where('tag_type', 1)
            ->get();
        return $tags;
    }

    public static function all_tags_job()
    {
        $tags = Category_tag::select('tag_type','tag_title')
            ->where('tag_type', 3)
            ->get();
        return $tags;
    }

    public static function all_tags_doc()
    {
        $tags = Category_tag::select('tag_type','tag_title')
            ->where('tag_type', 2)
            ->get();
        return $tags;
    }

    public static function get_all_Tags($tag_type)
    {
        $tags = Category_tag::select('tag_type','tag_title')
            ->where('tag_type', $tag_type)
            ->get();
        return $tags;
    }

}
