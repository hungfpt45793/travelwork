<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/8/2019
 * Time: 9:05 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Job;
use App\Entity\Order;
use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReportController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'report');

            return $next($request);
        });

    }

    public function revenue() {
        return view('report.revenue');
    }

    public function order() {
        return view('report.order');
    }

    public function job() {
        return view('report.job');
    }

    public function datatableRevenue(){
        $revenues = Order::where('status','=', 4);
        $revenues = $revenues->select('date_order',
                DB::raw('count(created_at) as order_number'),
                DB::raw('sum(total_price) as total_cost')
                )
            ->groupBy('date_order');
        return Datatables::of($revenues)
            ->orderColumn('date_order', 'desc')
            ->make(true);
    }

    public function datatableJob(){
        $jobs = Job::leftJoin('employer','employer.employer_id','=','jobs.employer_id')
            ->leftJoin('job_sale_package','job_sale_package.job_id','=','jobs.job_id')
            ->leftJoin('sale_package','sale_package.sale_package_id','=','job_sale_package.sale_package_id')
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.applicants',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.deadline_submit_profile'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job){
                return $job->number_recruit - $job->number_recruited;
            })
            ->orderColumn('jobs.job_id','jobs.job_id desc')
            ->make(true);
    }

    public function datatableOrder(){

    }
}