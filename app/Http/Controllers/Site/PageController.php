<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 1/23/2018
 * Time: 2:23 PM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Input;
use App\Entity\Post;
use Illuminate\Support\Facades\Log;

class PageController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }
    
    public function index($slug_post) {

        $post = $this->getPost($slug_post);

        if (empty($post)) {
            return redirect('/');
        }

        if ($post->template == 'default') {
            return view('site.default.page', compact('post'));
        } else {
            return view('site.template.'.$post->template, compact('post'));
        }
    }

    private function getPost($slug_post) {
        try {
            $post = Post::where('slug', $slug_post)
                ->where('post_type', 'page')
                ->first();

            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $post[$input->type_input_slug] = $input->content;
            }
            return $post;
        } catch (\Exception $e) {
            Log::error('http->site->PageController->getPost: Lỗi lấy dữ liệu post');

            return null;
        }
    }
}