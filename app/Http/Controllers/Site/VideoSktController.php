<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */
namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Diendan_input;
use App\Entity\Diendan_posts;
use App\Ultility\Ultility;
use Illuminate\Http\Request;


class VideoSktController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function video_skt(Request $request)
    {
        $posts = Diendan_posts::select('diendan_posts.*')
            ->where('visiable', 0)
            ->where('diendan_posts.post_type', 'post')
//            ->where('diendan_category_post.deleted_at', '=', null)
            ->distinct()
            ->orderBy('diendan_posts.created_at', 'desc');
//        if (!empty($request->input('word'))) {
//            $word = $request->input('word');
//            $posts = $posts->where('diendan_posts.slug', 'like', '%' . Ultility::createSlug($word) . '%');
//        }
//        $count = $posts->count();
//        echo $count;die;
        $posts = $posts->paginate(24);
//        foreach ($posts as $id => $post) {
//            $inputs = Diendan_input::where('post_id', $post->post_id)
//                ->get();
//            foreach ($inputs as $input) {
//                $posts[$id][$input->type_input_slug] = $input->content;
//            }
//        }
//        return view('site.video.video_skt', compact());
        return view('site.video.video_skt',compact('posts'));
    }

    public function detail_video_skt($slug)
    {
        $post = Diendan_posts::where('slug', $slug)
            ->where('post_type', 'post')
            ->first();

//        $inputs = Diendan_input::where('post_id', $post->post_id)->get();
//        foreach ($inputs as $input) {
//            $post[$input->type_input_slug] = $input->content;
//        }
        $view = $post->view + 1;
        $post_update = Diendan_posts::where('slug', $slug)
            ->update([
                'view' => $view,
            ]);
        return view('site.video.detail_video_skt',compact('post'));
    }


}
