<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Notification_post;
use App\Entity\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class PostController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($cate_slug, $slug_post)
    {
        $post = $this->getPostDetail($slug_post);
        if (empty($post)) {
            return redirect(route('home'));
        }
        $category = $this->getCategory($post);
        return view('site.default_site.single', compact('post', 'category', 'cate_slug'));
    }

    public function test($slug_post)
    {
        $post = $this->getPostDetail($slug_post);
        if (empty($post)) {
            return redirect(route('home'));
        }
        $category = $this->getCategory($post);
        return view('site.default_site.single_test', compact('post', 'category', 'cate_slug'));
    }

    public function support($cate_slug, $slug_post)
    {

        $post = $this->getPostDetail($slug_post);
        $category = $this->getCategory($post);
//        echo $slug_post;die();
//print_r($post);die();

        if (empty($category->template) or $category->template == 'ho-tro') {
            return view('site.default.single_support', compact('post', 'category', 'cate_slug'));
        } elseif (empty($post->template) or $post->template == 'default') {
            return view('site.default.single_support_profile', compact('post', 'category', 'cate_slug'));
        } else {
            return view('site.template.' . $post->template, compact('post', 'category', 'cate_slug'));
        }
    }

    private function getPostDetail($slug_post)
    {
        try {
            $post = Post::where('slug', $slug_post)
                ->where('post_type', 'post')
                ->first();
            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $post[$input->type_input_slug] = $input->content;
            }
            return $post;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');
            return null;
        }
    }

    private function getCategory($post)
    {
        try {
            $category = Category::join('category_post', 'categories.category_id', '=', 'category_post.category_id')
                ->select('categories.*')
                ->where('category_post.post_id', $post->post_id)
                ->first();

            if (empty($category)) {
                $category = Category::first();
            }

            return $category;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');

            return redirect('/');
        }
    }

    public function ajax_post_content(Request $request)
    {
        $dataid = $_GET['dataid'];
        if (empty($dataid)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $posts = new Post();
        $post = $posts->select('post_id', 'title', 'slug', 'content')->where('post_id', $dataid)->first();

        return response([
            'status' => 200,
            'post' => $post
        ])->header('Content-Type', 'text/plain');
    }

    public function search_post_ajax(Request $request)
    {
        $word = $request->input('word');
        if (empty($word)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $posts = new Post();
        $posts = $posts->select('post_id', 'title', 'slug', 'content')
            ->where('title', 'like', '%' . $word . '%')
            ->where('visiable', 0)
            ->where('posts.post_type', 'post')
            ->limit(8)
            ->get();
        return response([
            'status' => 200,
            'posts' => $posts
        ])->header('Content-Type', 'text/plain');
    }

    public function intro_app_sanketoan(Request $request)
    {
        return view('site.default_site.intro_app_sanketoan');
    }

    public function list_podcard()
    {
        $date = date('Y-m-j');
        $newdate = strtotime ( '-1 month' , strtotime ( $date ) ) ;
        $newdate_month = date ( 'm' , $newdate );
        $newdate_year  = date ( 'Y' , $newdate );
        $noti_post_model = new Notification_post();
//        $noti_post_model = new Notification_post();
//        echo $newdate_month.'-'.$newdate_year;die;
        $list_2_month = $noti_post_model->whereMonth('created_at', '<=',$newdate_month)
            ->whereYear('created_at', '<=',$newdate_year)
            ->get();
        echo '<pre>';
        print_r($list_2_month);die;
    }
}
