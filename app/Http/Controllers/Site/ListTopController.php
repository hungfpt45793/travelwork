<?php

namespace App\Http\Controllers\Site;

use App\Entity\Job;
use App\Entity\Job_sale_statistical;
use App\Entity\Post;
use App\Entity\Post_sale_statistical;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ListTopController extends SiteController
{
    //
    public function __construct(){
        parent::__construct();
    }
    public function show_category_post()
    {
        return view('site.default.show_category_post');
    }
  public function list_category_post_share()
    {
        return view('site.default.list_category_post_share');
    }

    public function list_post_share()
    {
        $post_model = new Post();
        $list_post = $post_model->select('posts.title', 'posts.slug','posts.post_id','posts.visiable','posts.sale_money','post_sale_statistical.post_id','post_sale_statistical.employee_id','post_sale_statistical.total_share','post_sale_statistical.total_view_sale','post_sale_statistical.total_money_view','post_sale_statistical.created_at','post_sale_statistical.updated_at','employees.employee_id','employees.employee_name','employees.employee_image')
            ->rightJoin('post_sale_statistical','post_sale_statistical.post_id','=','posts.post_id')
            ->rightJoin('employees','employees.employee_id','=','post_sale_statistical.employee_id')
            ->where('posts.sale_money',1)
            ->orderBy('post_sale_statistical.total_view_sale','desc')
            ->distinct('post_sale_statistical.post_id')
            ->groupBy('posts.title', 'posts.slug','posts.post_id','posts.visiable','posts.sale_money','post_sale_statistical.post_id','post_sale_statistical.employee_id','post_sale_statistical.total_share','post_sale_statistical.total_view_sale','post_sale_statistical.total_money_view','post_sale_statistical.created_at','post_sale_statistical.updated_at','employees.employee_id','employees.employee_name','employees.employee_image')
            ->paginate(20);
//        echo '<pre>';
//        print_r($list_post);
//        echo '</pre>';
//        die();
        return view('site.employee.list_post_share',compact('list_post'));
    }
    public function list_job_share()
    {
//        echo 1;die();
        $job_model = new Job();
        $list_job = $job_model->select('jobs.title', 'jobs.slug','jobs.job_id','jobs.deadline_submit_profile','jobs.sale_money','jobs.active_job','job_sale_statistical.job_id','job_sale_statistical.employee_id','job_sale_statistical.total_share','job_sale_statistical.total_view_sale','job_sale_statistical.total_money_view','job_sale_statistical.created_at','job_sale_statistical.updated_at','employees.employee_id','employees.employee_name','employees.employee_image')
            ->rightJoin('job_sale_statistical','job_sale_statistical.job_id','=','jobs.job_id')
            ->rightJoin('employees','employees.employee_id','=','job_sale_statistical.employee_id')
            ->where('jobs.sale_money',1)
             ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
             ->where('jobs.active_job', 1)
            ->orderBy('job_sale_statistical.total_view_sale','desc')
            ->distinct('job_sale_statistical.job_id')
            ->groupBy('jobs.title', 'jobs.slug','jobs.job_id','jobs.deadline_submit_profile','jobs.sale_money','jobs.active_job','job_sale_statistical.job_id','job_sale_statistical.employee_id','job_sale_statistical.total_share','job_sale_statistical.total_view_sale','job_sale_statistical.total_money_view','job_sale_statistical.created_at','job_sale_statistical.updated_at','employees.employee_id','employees.employee_name','employees.employee_image')
            ->paginate(20);
//        echo '<pre>';
//        print_r($list_post);
//        echo '</pre>';
//        die();
//        echo '<pre>';
//        print_r($list_job);die();
        return view('site.employee.list_job_share',compact('list_job'));
    }
    public function list_change_product()
    {
        $list_product_model = new List_product();
        $list_product = $list_product_model->select('*')->orderBy('product_id','desc')->paginate('30');

        return view('site.employee.list_product',compact('list_product'));
    }
    public function show_list_post()
    {
        $post_model = new Post();
        $list_post_new =  $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content','posts.image','posts.updated_at','posts.sale_money','posts.updated_at','posts.meta_description')
            ->where('sale_money',1 )
            ->orderBy('post_id','desc')
            ->paginate(10);

        $post_sale = new Post_sale_statistical();

        $list_post = $post_sale->select(DB::raw('SUM(total_view_sale) as total_view'),'post_sale_statistical.post_id')->groupBy('post_sale_statistical.post_id')->orderBy('total_view','desc')->limit(18)->get();

//        $list_post =  $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content','posts.image','posts.updated_at','posts.sale_money','posts.updated_at','posts.meta_description','post_sale_statistical.total_view_sale','post_sale_statistical.post_id')
//            ->leftJoin('post_sale_statistical','post_sale_statistical.post_id','=','posts.post_id')
//            ->where('sale_money',1 )
//            ->orderBy('post_sale_statistical.total_view_sale','desc')
//            ->distinct('post_sale_statistical.post_id')
//            ->limit(18)->get();

        return view('site.employee.show_list_post', compact( 'list_post_new','list_post'));
    }
    public function show_list_job()
    {
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title','jobs.sale_money', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province','jobs.active_job'
            );
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('jobs.sale_money', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        //tong so bai viet
        $total_jobs = $list_jobs->count();
        $list_jobs = $list_jobs->paginate(20);
//        luu url khi phan trang
        $list_jobs->appends(request()->query());

        $list_jobs_new = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title','jobs.sale_money', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province','jobs.active_job'
            );
        $list_jobs_new = $list_jobs_new->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs_new = $list_jobs_new->where('jobs.active_job', 1);
        $list_jobs_new = $list_jobs_new->where('jobs.sale_money', 1);
        $list_jobs_new = $list_jobs_new->orderBy('jobs.job_id', 'desc');
        //tong so bai viet
        $list_jobs_new = $list_jobs_new->limit(10)->get();


        return view('site.employee.show_list_job', compact('employee', 'list_jobs','list_jobs_new'));
    }
}
