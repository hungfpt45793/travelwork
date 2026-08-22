<?php

namespace App\Http\Controllers\Api;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Input;
use App\Entity\Job;
use App\Entity\Post;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class PostController extends Controller
{
//http://sanketoan.local/api/tin-tuc/kinh-nghiem-de-tuyen-dung-duoc-mot-ke-toan-tong-hop-co-ky-nang-xu-ly-cong-viec-gioi
    public function getPost($slug_post)
    {
        $post = $this->getPostDetail($slug_post);

        if(empty($post)){
            return response([
                'status' => 404,
                'message' => 'Không tồn tại bài viết này'
            ],404);
        }
        return response([
            'status' => 200,
            'post' => $post,
        ],200);

    }
//http://sanketoan.local/api/danh-muc/tin-tuc
    private function getPostDetail($slug_post)
    {
        try {
            $post = Post::select('post_id',
                'title',
                'slug',
                'description',
                'tags',
                'content',
                'image',
                'updated_at'
               )->where('slug', $slug_post)
                ->where('post_type', 'post')
                ->first();
            return $post;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');
            return null;
        }
    }

    public  function getCategory($slug) {

            $postModel = new Post();
            $categoryModel = new Category();
            $category = $categoryModel->where('slug', $slug)
                ->where('post_type', 'post')
                ->first();

            $posts = $postModel->select('posts.post_id',
                'posts.title',
                'posts.slug',
                'posts.description',
                'posts.tags',
                'posts.content',
                'posts.image',
                'posts.updated_at')->join('category_post', 'category_post.post_id', '=', 'posts.post_id')
                ->where('category_post.category_id', $category->category_id)
                ->where('visiable', 0)
                ->orderBy('posts.post_id', 'desc')
                ->distinct()
                ->where('category_post.deleted_at', null)
                ->paginate(20);


            if(empty($posts)){
                return response([
                    'status' => 404,
                    'message' => 'Không tồn danh mục tại bài viết này'
                ],404);
            }
            return response([
                'status' => 200,
                'posts' => $posts,
            ],200);
    }

}
