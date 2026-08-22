<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Diendan_posts extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    use Rating;

    protected $table = 'diendan_posts';

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'post_id',
        'title',
        'slug',
        'description',
        'tags',
        'content',
        'content_summary',
        'content_video',
        'template',
        'image',
        'post_type',
        'parents',
        'is_hide',
        'visiable',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'category_string',
        'product_list',
        'view',
        'status_video',
        'link_video',
        'audio_noidung',
        'audio_tomtat',
        'audio_phantich',
        'day_create',
        'day_active',
        'status_doc',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    public static function relativeProduct($slug, $countProduct=10) {
        try {
            $postModel = new Diendan_posts();

            $categoriesDB = $postModel->where('diendan_posts.post_type', 'post')
                ->join('diendan_category_post', 'diendan_posts.post_id', '=', 'diendan_category_post.post_id')
                ->join('diendan_categories', 'diendan_category_post.category_id', '=', 'diendan_categories.category_id')
                ->where('diendan_posts.slug', $slug)
                ->where('visiable', 0)
                ->select(
                    'diendan_categories.category_id'
                )
                ->get();

            $categories = array();
            foreach($categoriesDB as $category) {
                $categories[] =  $category->category_id;
            }

            $posts = $postModel->where('diendan_posts.post_type', 'post')
                ->join('diendan_category_post', 'diendan_posts.post_id', '=', 'diendan_category_post.post_id')
                ->join('diendan_categories', 'diendan_category_post.category_id', '=', 'diendan_categories.category_id')
                ->whereIn('diendan_categories.category_id', $categories)
                ->select(
                    'diendan_posts.*'
                )
                ->where('visiable', 0)
                ->where('diendan_posts.slug','!=', $slug)
                ->offset(0)
                ->limit($countProduct)->distinct()->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy bài viết liên quan.');

            return array();
        }

    }

}
