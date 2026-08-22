<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    public function index( Request $request, $slug_cate) {
        $posts = $this->getPosts($request , $slug_cate);
        return view('site.default_site.category', compact('posts','slug_cate'));

    }

    private function getCategoryDetail($cateSlug) {
        try {
            $category = Category::where('slug', $cateSlug)
                ->where('post_type', 'post')
                ->first();
            $inputs = Input::where('cate_id', $category->category_id)->get();
            foreach ($inputs as $input) {
                $category[$input->type_input_slug] = $input->content;
            }
            return $category;
        } catch (\Exception $e) {
            Log::error('http->site->CategoryController->getCategoryDetail: Lỗi hiển thị category');
            return redirect('/');
        }
    }

    private function getPosts($request , $slug_cate) {
//        try {
            $posts = Post::select('posts.post_id',
                'posts.title',
                'posts.slug',
                'posts.description',
                'posts.tags',
                'posts.content',
                'posts.updated_at',
                'posts.template',
                'posts.image',
                'posts.post_type')
                ->leftJoin('category_post','category_post.post_id' , 'posts.post_id')
                ->leftJoin('categories','categories.category_id' , 'category_post.category_id')
                ->where('categories.slug',$slug_cate)
                ->where('visiable', 0)
                ->where('posts.post_type', 'post')
                ->orderBy('posts.post_id', 'desc');

            if (!empty($request->input('word'))) {
                $word = $request->input('word');
                $posts =  $posts->where('posts.title', 'like', '%'.$word.'%');
            }
            $posts = $posts->paginate(10);
            $posts->appends(request()->query());
            return $posts;
//        } catch(\Exception $e) {
//            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
//
//            return array();
//        }
    }


}
