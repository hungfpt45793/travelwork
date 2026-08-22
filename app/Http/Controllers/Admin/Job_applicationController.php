<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Career;
use App\Entity\Job_application;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Job_applicationController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'jobs');
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total = Job_application::select('*')->count();
        $list_job_app = Job_application::select('*')->get();

        return view('admin.job_app.list', compact('list_job_app', 'total'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caree = new Career();
        $list_category_caree = $caree->get();
        return view('admin.job_app.add', compact('list_category_caree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = Job_application::insert([
            'job_app_name' => $request->input('job_app_name'),
            'job_app_content' => $request->input('job_app_content'),
            'career_category_id' => $request->input('career_category_id'),
            'user_id' => Auth::user()->id,
            'created_at'=> new \DateTime(),
        ]);
        return redirect(route('job_app.index'))->with('thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list_category_caree = Career::get();
        $job_app = Job_application::where('job_app_id',$id)->first();
        return view('admin.job_app.edit', compact('list_category_caree','job_app'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Job_application::where('job_app_id',$id)->update([
            'job_app_name' => $request->input('job_app_name'),
            'job_app_content' => $request->input('job_app_content'),
            'career_category_id' => $request->input('career_category_id'),
            'user_id' => Auth::user()->id,
            'updated_at'=> new \DateTime(),
        ]);
        return redirect(route('job_app.index'))->with('cập nhật  thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Job_application::where('job_app_id',$id)->delete();
        return redirect(route('job_app.index'))->with('Xóa thành công');
    }
}
