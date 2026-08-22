<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cron_posts extends Model
{
    protected $table = 'cron_posts';
    protected $primaryKey = 'cron_post_id';
    public $timestamps = false;
    protected $fillable = [
        'cron_post_id',
        'slug_category',
        'title',
        'post_id',
        'post_slug',
        'image',
        'description',
        'created_at',
        'updated_at',
    ];
    public static function get_all_cron_posts()
    {
        $cron_post = new Cron_posts();
        $cron_post = $cron_post->select('*')->orderBy('cron_post_id','desc')->get();
        return $cron_post;
    }
}
