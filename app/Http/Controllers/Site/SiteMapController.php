<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Career;
use App\Entity\Category;
use App\Entity\Category_tag;
use App\Entity\Coefficients_salary;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\Province;
use App\Entity\Teacher;
use App\Entity\TypeOfBusiness;
use App\Entity\Voucher;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Exam\CategoriesExam;
use App\Exam\CommentExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\ResultExam;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;


class SiteMapController extends SiteController
{
    //site map tong
    //danh mục tài liệu
//Route::get('sitemap/category_voucher.xml', 'SiteMapController@category_voucher');
//    //site map công việc facebook
//Route::get('sitemap/jobfacebook.xml', 'SiteMapController@sitemap_jobfacebook');
//    //site map công việc NTD
//Route::get('sitemap/job.xml', 'SiteMapController@sitemap_job');
//    //site map cổng thực tập
//Route::get('sitemap/intership.xml', 'SiteMapController@sitemap_intership');
//    //site map kho tài liệu
//Route::get('sitemap/voucher.xml', 'SiteMapController@sitemap_voucher');
//    //site map tin tức
//Route::get('sitemap/post.xml', 'SiteMapController@sitemap_post');
//    //site map đề thi
//Route::get('sitemap/exam.xml', 'SiteMapController@sitemap_exam');
//    //site map giáo viên
//Route::get('sitemap/teacher.xml', 'SiteMapController@sitemap_teacher');
//site map danh mục tin tức
//Route::get('sitemap/categories.xml', 'SiteMapController@sitemap_categories');
////site map chi tiet nha tuyen dung
//Route::get('sitemap/categories.xml', 'SiteMapController@sitemap_employer');
    public function sitemap_all()
    {
        $sitemaps[] = 'https://sanketoan.vn/sitemap/jobfacebook.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/job.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/intership.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/category_voucher.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/voucher.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/categories.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/post.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/exam.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/teacher.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/employer.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/tag.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/tag_post.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/tag_voucher.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/tag_job.xml';
        $sitemaps[] = 'https://sanketoan.vn/sitemap/coe_salary.xml';
        return response()->view('site.sitemap.sitemap_all', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
    }
    public function category_voucher()
    {
        $sitemaps = array();
        // trang chủ
        $category_voucher = new VoucherCategories();
        $category_vouchers = $category_voucher->select('*')->orderBy('id_cate_voucher', 'desc')->get();
        foreach ($category_vouchers as $category) {
            $sitemaps[] = array(
                'url' => route('getAllCategoryVoucher', ['slugCategoryVoucher' => $category->slug_cate_voucher]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($category->updated_at)),
                'priority' => 0.9
            );
            $category_child = new VoucherChildCategories();
            $category_childs = $category_child->select('*')->orderBy('id_cate_child', 'desc')->get();
            foreach ($category_childs as $category_cl) {
                $sitemaps[] = array(
                    'url' => route('getChildVoucher', ['slugChildVoucher' => $category_cl->slug_cate_child]),
                    'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($category_cl->updated_at)),
                    'priority' => 0.8
                );
            }
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_jobfacebook()
    {
        $sitemaps = array();
        // trang chủ
        $jobfaceModule = new JobFacebook();
        $jobfaces = $jobfaceModule->select('*');
        $jobfaces = $jobfaces->where('warning_job_fb', '<', 4);
        $jobfaces = $jobfaces->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $jobfaces = $jobfaces->orderBy('job_facebook.job_facebook_id', 'desc');
        $jobfaces = $jobfaces->limit(500);
        $jobfaces = $jobfaces->get();
        foreach ($jobfaces as $jobface) {
            $sitemaps[] = array(
                'url' => route('detail_job_face', ['slug' => $jobface->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($jobface->updated_at)),
                'changefreq' => 'daily',
                'priority' => 0.7
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_job()
    {
        $sitemaps = array();
        // trang chủ
        $jobModel = new Job();
        $jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->join('employer', 'employer.employer_id', 'jobs.employer_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $jobs = $jobs->orderBy('jobs.vip', 'desc');
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $jobs = $jobs->limit(500)->get();

        foreach ($jobs as $job) {
            $sitemaps[] = array(
                'url' => route('job_detail', ['slug' => $job->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($job->updated_at)),
                'changefreq' => 'daily',
                'priority' => 0.8
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_intership()
    {
        $sitemaps = array();
        // trang chủ
        $employer = new Employer();
        $employers = $employer->select('employer_id', 'view', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'banner_intership', 'type_of_business_id', 'business', 'updated_at');
        $employers = $employers->where('status_intership', 1);
        $employers = $employers->orderBy('employer_id', 'desc');
        $employers = $employers->limit(500)->get();

        foreach ($employers as $employer) {
            $sitemaps[] = array(
                'url' => route('detail_intership', ['slug' => $employer->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($employer->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.6
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_voucher()
    {
        $sitemaps = array();
        // trang chủ
        $voucher_model = new Voucher();
        $vouchers = $voucher_model->select('*');
        $vouchers = $vouchers->orderBy('view_voucher', 'desc');
        $vouchers = $vouchers->orderBy('dowload_voucher', 'desc');
        $vouchers = $vouchers->orderBy('id_voucher', 'desc');
        $vouchers = $vouchers->limit(500)->get();

        foreach ($vouchers as $voucher) {
            $sitemaps[] = array(
                'url' => route('getVoucher', ['slug_voucher' => $voucher->slug_voucher]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($voucher->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.5
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

//Route::get('{slug_cate}/tin-tuc', 'CategoryController@index')->name('site_category_post');
    public function sitemap_categories()
    {
        $categories = new Category();
        $categories = $categories->select('*')->get();
        foreach ($categories as $cate) {
            $sitemaps[] = array(
                'url' => route('site_category_post', ['slug_cate' => $cate->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($cate->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.4
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_post()
    {
        $sitemaps = array();
        // trang chủ
        $post_modal = new Post();

        $posts = $post_modal->select('*');
        $posts = $posts->where('post_type', 'post');
        $posts = $posts->orderBy('updated_at', 'desc');
        $posts = $posts->limit(500)->get();

        foreach ($posts as $post) {
            $sitemaps[] = array(
                'url' => route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($post->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.3
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_exam()
    {
        $sitemaps = array();
        // trang chủ
        $exam_model = new Exam();
        $exams = $exam_model->select('*')
            //where trang thai public hoac prive cua de thi
            ->where('exam.bank_exam', '=', 1)
            ->limit(500)->get();
        foreach ($exams as $exam) {
            $sitemaps[] = array(
                'url' => route('getTestExam', ['slug_exam' => $exam->slug_exam]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($exam->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.2
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_teacher()
    {
        $sitemaps = array();
        // trang chủ
        $teacher_model = new Teacher();
        $teachers = $teacher_model->select('teacher.province', 'teacher.district', 'teacher.business_type_id', 'teacher.teacher_name', 'teacher.teacher_id', 'teacher.slug', 'information_verifier', 'address', 'updated_at')
            ->orderBy('teacher_id', 'desc')
            ->limit(500)
            ->get();

        foreach ($teachers as $teacher) {
            $sitemaps[] = array(
                'url' => route('detailTeacher', ['slug' => $teacher->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($teacher->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.1
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
        // return Sitemap::index();
    }

    public function sitemap_employer()
    {
        $sitemaps = array();
        // trang chủ
        $employer = new Employer();
        $employers = $employer->select('employer_id', 'view', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'banner_intership', 'type_of_business_id', 'business', 'updated_at');
        $employers = $employers->orderBy('employer_id', 'desc');
        $employers = $employers->limit(500)->get();

        foreach ($employers as $employer) {
            $sitemaps[] = array(
                'url' => route('detail_employer', ['slug' => $employer->slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($employer->updated_at)),
                'changefreq' => 'monthly',
                'priority' => 0.7
            );
            // Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_tag()
    {
        $sitemaps = array();
        // trang chủ
        $date = new \DateTime();
//        print_r($date);die();
        //tạo site cho 3 danh mục tag chính
        $sitemaps[] = array(
            'url' => route('list_type_post'),
            'lastmod' => date_format($date, "Y-m-d\TH:i:s+00:00"),
            'changefreq' => 'monthly',
            'priority' => 0.9
        );
        $sitemaps[] = array(
            'url' => route('list_type_voucher'),
            'lastmod' => date_format($date, "Y-m-d\TH:i:s+00:00"),
            'changefreq' => 'monthly',
            'priority' => 0.9
        );
        $sitemaps[] = array(
            'url' => route('list_type_job'),
            'lastmod' => date_format($date, "Y-m-d\TH:i:s+00:00"),
            'changefreq' => 'monthly',
            'priority' => 0.9
        );
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_tag_post()
    {
        $category_tag = new Category_tag();
        $category_tag_post = $category_tag->select('*')
            ->where('tag_type', 1)
            ->orderBy('tag_id', 'desc')
            ->get();
        foreach ($category_tag_post as $post) {
            $sitemaps[] = array(
                'url' => route('detail_type_post', ['tag_slug' => $post->tag_slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($post->created_at)),
                'changefreq' => 'monthly',
                'priority' => 0.7
            );
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_tag_voucher()
    {
        $category_tag = new Category_tag();
        $category_tag_voucher = $category_tag->select('*')
            ->where('tag_type', 2)
            ->orderBy('tag_id', 'desc')
            ->get();
        foreach ($category_tag_voucher as $voucher) {
            $sitemaps[] = array(
                'url' => route('detail_type_voucher', ['tag_slug' => $voucher->tag_slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($voucher->created_at)),
                'changefreq' => 'monthly',
                'priority' => 0.7
            );
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }

    public function sitemap_tag_job()
    {
        $category_tag = new Category_tag();
        $category_tag_job = $category_tag->select('*')
            ->where('tag_type', 3)
            ->orderBy('tag_id', 'desc')
            ->get();

        foreach ($category_tag_job as $job) {
            $sitemaps[] = array(
                'url' => route('detail_type_job', ['tag_slug' => $job->tag_slug]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($job->created_at)),
                'changefreq' => 'monthly',
                'priority' => 0.7
            );
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }
    public function list_provice_category_career()
    {
//        $career = new Career();
//        $list_career = $career->select('*')->get();
//
//        $province = new Province();
//        $list_province = $province->select('*')->orderBy('sort_id','asc')->get();
//        foreach ($list_career as $carrer) {
//            $sitemaps[] = array(
//                'url' => route('search_employee').'?career='.$carrer->career_category_id,
//                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($carrer->created_at)),
//                'priority' => 0.7
//            );
//        }
//        foreach ($list_province as $province) {
//            $sitemaps[] = array(
//                'url' => route('search_employee').'?province='.$province->province_id,
//                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($province->updated_at)),
//                'priority' => 0.7
//            );
//        }
//        // Return the sitemap to the client.
//        return response()->view('site.sitemap.sitemap', [
//            'sitemaps' => $sitemaps,
//        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }
    public function coe_salary()
    {
        $coe_model = new Coefficients_salary();
        $list_coe = $coe_model->select('coefficients_salary.*','career_categories.career_category_slug')
            ->join('career_categories','career_categories.career_category_id','=','coefficients_salary.career_category_id')
            ->orderBy('coe_id', 'desc')
            ->get();

        foreach ($list_coe as $coe) {
            $sitemaps[] = array(
                'url' => route('total_get_all_coe', ['career_category_slug' => $coe->career_category_slug,'coe_id'=>$coe->coe_id]),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($coe->created_at)),
                'changefreq' => 'monthly',
                'priority' => 0.7
            );
        }
        // Return the sitemap to the client.
        return response()->view('site.sitemap.sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }
}
