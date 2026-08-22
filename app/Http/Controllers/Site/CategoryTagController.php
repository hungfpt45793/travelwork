<?php

namespace App\Http\Controllers\Site;

use App\Ultility\Ultility;
use App\Entity\Category;
use App\Entity\Category_tag;
use App\Entity\Input;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\Post;
use App\Entity\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class CategoryTagController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

//    bài viết
    public function list_type_post(Request $request)
    {
        try
        {
            $category_tag = Category_tag::select('*')->where('tag_type', 1)->orderBy('updated_at','desc');
            if(!empty($request->input('tag_title')))
            {
                $tag_title = $request->input('tag_title');
                $category_tag = $category_tag->where('tag_title','like','%'.$tag_title.'%');
            }
            $category_tag = $category_tag->paginate(100);

            return view('site.category_tag.list_type_post', compact('category_tag'));
        }catch (\Exception $e)
        {
            Log::error('http->site->PostController->getPostDetail: lỗi không lấy dc danh sách tag bai viết');
            return view('site.category_tag.error_tag');
        }

    }

    // tự động hoàn thành tag
    public function autocompleteTag(Request $request)
    {
        $datas = Category_tag::select("tag_title")
        // ->where("tag_title","LIKE","%{$request->input('query')}%")
        ->get();
        $dataModified = array();
        foreach ($datas as $data)
        {
            $dataModified[] = $data->tag_title;
        }

        return response()->json($dataModified);
    }

    public function detail_type_job($tag_slug)
    {
        $category_tag = Category_tag::select('*')
            ->where('tag_type', 3)
            ->where('tag_slug', 'LIKE','%'.$tag_slug.'%')
            ->first();
        if(empty($category_tag))
        {
            return redirect(route('home'));
        }
        $title = $category_tag->tag_title;
        $user = Auth::user();
        $list_jobs = $this->getJobs($title);
        $list_job_fb = $this->getJobs_fb($title);
        // $category_tag = $category_tag->slug;
        // dd($list_jobs);
        return view('site.category_tag.detail_type_job', compact('list_jobs', 'list_job_fb', 'user','category_tag'));
    }

    private function getJobs_fb($tag_title) {
        //        try {
        $jobs = JobFacebook::select('job_facebook.*')
            ->where('deleted_at', 'null')
            ->where('title','like','%'.$tag_title.'%')
            ->orwhere('des_facebook','like','%'.$tag_title.'%')
            ->orwhere('content','like','%'.$tag_title.'%')
            ->orwhere('slug','like','%'.$tag_title.'%')
            ->orwhere('phone','like','%'.$tag_title.'%')
            ->orwhere('email','like','%'.$tag_title.'%')
            ->orwhere('address','like','%'.$tag_title.'%')
            ->orwhere('province','like','%'.$tag_title.'%')
            ->orwhere('code','like','%'.$tag_title.'%')
            ->orwhere('district','like','%'.$tag_title.'%')
            ->orwhere('company_name','like','%'.$tag_title.'%')
            ->orwhere('tags','like','%'.$tag_title.'%')
            ->orderBy('job_facebook_id', 'desc')
            ;
        $jobs = $jobs->paginate(10);
        $jobs->appends(request()->query());
        return $jobs;
        //        } catch(\Exception $e) {
        //            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
        //
        //            return array();
        //        }
    }

    private function getJobs($tag_title) {
        //        try {
        $jobs = Job::select('jobs.*')
            ->where('deleted_at', 'null')
            ->where('title','like','%'.$tag_title.'%')
            ->orwhere('content','like','%'.$tag_title.'%')
            ->orwhere('slug','like','%'.$tag_title.'%')
            ->orwhere('description','like','%'.$tag_title.'%')
            ->orwhere('gender','like','%'.$tag_title.'%')
            ->orwhere('position','like','%'.$tag_title.'%')
            ->orwhere('district','like','%'.$tag_title.'%')
            ->orwhere('province','like','%'.$tag_title.'%')
            ->orwhere('address_work','like','%'.$tag_title.'%')
            ->orwhere('tags','like','%'.$tag_title.'%')
            ->orwhere('meta_title','like','%'.$tag_title.'%')
            ->orwhere('meta_description','like','%'.$tag_title.'%')
            ->orwhere('meta_keyword','like','%'.$tag_title.'%')
            ->orwhere('welfare','like','%'.$tag_title.'%')
            ->orderBy('job_id', 'desc')
            ;
        $jobs = $jobs->paginate(10);
        $jobs->appends(request()->query());
        return $jobs;
        //        } catch(\Exception $e) {
        //            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
        //
        //            return array();
        //        }
    }



    public function detail_type_post($tag_slug)
    {

        $category_tag = Category_tag::select('*')
            ->where('tag_type', 1)
            ->where('tag_slug', 'LIKE','%'.$tag_slug.'%')
            ->first();
        if(empty($category_tag))
        {
            return redirect(route('home'))->with('mesage_modal','Không tim thấy từ khóa này');
        }
        $posts = $this->getPosts($category_tag->tag_title);
        $total = $this->get_total_Posts($category_tag->tag_title);
        $slug_cate = $category_tag->slug;
        $post_new =$this->Posts_new();
        return view('site.category_tag_site.detail_type_post', compact('category_tag','posts','total','post_new', 'slug_cate'));
    }

    private function getPosts($tag_title) {
//        try {
        $posts = Post::select('posts.*')
            ->leftJoin('category_post','category_post.post_id' , 'posts.post_id')
            ->leftJoin('categories','categories.category_id' , 'category_post.category_id')
            ->where('visiable', 0)
            ->where('posts.post_type', 'post')
            ->where('posts.title','like','%'.$tag_title.'%')
            ->orwhere('posts.description','like','%'.$tag_title.'%')
            ->orwhere('posts.content','like','%'.$tag_title.'%')
            ->orwhere('posts.slug','like','%'.$tag_title.'%')
            ->orwhere('posts.meta_title','like','%'.$tag_title.'%')
            ->orwhere('posts.meta_description','like','%'.$tag_title.'%')
            ->orwhere('posts.meta_keyword','like','%'.$tag_title.'%')
            ->orwhere('posts.tags','like','%'.$tag_title.'%')
            ->orderBy('posts.post_id', 'desc')
            ;
        $posts = $posts->paginate(10);
        $posts->appends(request()->query());
        return $posts;
//        } catch(\Exception $e) {
//            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
//
//            return array();
//        }
    }
    private function get_total_Posts($tag_title) {
//        try {
        $posts = Post::select('posts.*')
            ->leftJoin('category_post','category_post.post_id' , 'posts.post_id')
            ->leftJoin('categories','categories.category_id' , 'category_post.category_id')
            ->where('posts.title','like','%'.$tag_title.'%')
            ->where('visiable', 0)
            ->where('posts.post_type', 'post')
            ->orderBy('posts.post_id', 'desc');
        $posts = $posts->count();

        return $posts;
//        } catch(\Exception $e) {
//            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
//
//            return array();
//        }
    }

    private function Posts_new() {
//        try {
        $posts = Post::select('posts.*')
            ->leftJoin('category_post','category_post.post_id' , 'posts.post_id')
            ->leftJoin('categories','categories.category_id' , 'category_post.category_id')
            ->where('visiable', 0)
            ->where('posts.post_type', 'post')
            ->orderBy('posts.post_id', 'desc');
        $posts = $posts->paginate(10);
        return $posts;
//        } catch(\Exception $e) {
//            Log::error('http->site->CategoryController->getPosts: Lỗi hiển thị category');
//
//            return array();
//        }
    }

    //tài liệu
    public function list_type_voucher(Request $request)
    {
        try
        {
            $category_tag = Category_tag::select('*')->where('tag_type', 2)->orderBy('updated_at','desc');
            if(!empty($request->input('tag_title')))
            {
                $tag_title = $request->input('tag_title');
                $category_tag = $category_tag->where('tag_title','like','%'.$tag_title.'%');
            }
            $category_tag = $category_tag->paginate(100);
            return view('site.category_tag.list_type_voucher', compact('category_tag'));
        }catch (\Exception $e)
        {
            Log::error('http->site->PostController->getPostDetail: lỗi không lấy dc danh sách tag tài liệu');
            return view('site.category_tag.error_tag');
        }

    }

    public function detail_type_voucher($tag_slug)
    {
        $category_tag = Category_tag::select('*')
            ->where('tag_type', 2)
            ->where('tag_slug', $tag_slug)
            ->first();
        $list_voucher = Voucher::select('name_voucher',
            'slug_voucher',
            'des_voucher',
            'image_voucher',
            'content_voucher',
            'type_voucher',
            'view_voucher',
            'link_dowload_voucher',
            'link_dowload_file',
            'dowload_voucher',
            'created_at')
            ->where('name_voucher','like','%'.$category_tag->tag_title.'%');
        $total = $list_voucher->count();
        $list_voucher = $list_voucher->paginate(20);
        $list_voucher_new = Voucher::select('name_voucher',
            'slug_voucher',
            'des_voucher',
            'image_voucher',
            'content_voucher',
            'type_voucher',
            'view_voucher',
            'link_dowload_voucher',
            'link_dowload_file',
            'dowload_voucher',
            'created_at')
            ->orderBy('id_voucher','desc')
            ->limit(12)
            ->get();
//        echo '<pre>';
//        print_r($list_voucher);die();


        return view('site.category_tag.detail_type_voucher', compact('category_tag','list_voucher','list_voucher_new','total'));
    }

    //việc làm
    public function list_type_job(Request $request)
    {
        try
        {
            $category_tag = Category_tag::select('*')->where('tag_type', 3)->orderBy('updated_at','desc');
            if(!empty($request->input('tag_title')))
            {
                $tag_title = $request->input('tag_title');
                $category_tag = $category_tag->where('tag_title','like','%'.$tag_title.'%');
            }
            $category_tag = $category_tag->paginate(100);
            return view('site.category_tag.list_type_job', compact('category_tag'));
        }catch (\Exception $e)
        {
            Log::error('http->site->PostController->getPostDetail: lỗi không lấy dc danh sách tag cong việc');
            return view('site.category_tag.error_tag');
        }
    }

    public function them_tu_khoa_ajax (Request $request)
    {
        if(!empty($request->tag_title))
        {
            $tag_type = $request->input('tag_type');
            $tag_id = Category_tag::insertGetId([
                'tag_title' => $request->tag_title,
                'tag_description' => $request->tag_description,
                'tag_type' => $tag_type,
                'created_at' => new \DateTime()
            ]);
            $tag_slug = Ultility::createSlug($request->input('tag_title'));

            $postWithSlug = Category_tag::where('tag_slug', $tag_slug)->first();
            if (empty($postWithSlug)) {
                Category_tag::where('tag_id', $tag_id)
                    ->update([
                        'tag_slug' => $tag_slug
                    ]);
            } else {
                Category_tag::where('tag_id', '=', $tag_id)
                    ->update([
                        'tag_slug' => $tag_slug.'-'.$tag_id
                    ]);
            }
            $input_tags_reload = Category_tag::get_all_Tags($tag_type);
            return response()->json([
                'success' => 200,
                'input_tags_reload' => $input_tags_reload
            ]);
        }
        return response()->json([
            'success' => 400,
            'message' => 'Tiêu đề không dc để trống'
        ]);

    }



//
//     public function detail_type_job1111($tag_slug)
//     {
//         $category_tag = Category_tag::select('*')
//             ->where('tag_type', 3)
//             ->where('tag_slug','LIKE','%'.$tag_slug.'%')
//             ->first();
//         $user = Auth::user();
//         $jobModel = new Job();
//         $list_jobs = $jobModel
//             ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
//             ->select(
//                 'jobs.title', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
//                 'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province','jobs.active_job'
//             );
//         $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
//         $list_jobs = $list_jobs->where('jobs.active_job', 1);
//         $list_jobs = $list_jobs->where('jobs.title', 'like','%'.$category_tag->tag_title.'%');
//         $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
//         $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
//         //tong so bai viet
//         $total_jobs = $list_jobs->count();
//         $list_jobs = $list_jobs->paginate(20, ['*'], 'page_1s');
// //        luu url khi phan trang
//         $list_jobs->appends(request()->query());


//         $jobFb_model = new JobFacebook();
//         $list_job_fb = $jobFb_model->select(
//             'job_facebook.*',
//             'salary.description as salary_description', 'salary.salary_id'
//         );
//         $list_job_fb = $list_job_fb->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
//         $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//         $list_job_fb = $list_job_fb->where('job_facebook.title', 'like','%'.$category_tag->tag_title.'%');
// //        sắp xếp theo lương
//         $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
//         $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
//         $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
//         $list_job_fb = $list_job_fb->paginate(20, ['*'], 'page_2s');
//         $list_job_fb->appends(request()->query());
//         return view('site.category_tag.detail_type_job', compact('list_jobs', 'list_job_fb', 'user','category_tag'));
//     }
}
