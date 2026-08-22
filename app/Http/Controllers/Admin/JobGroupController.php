<?php

namespace App\Http\Controllers\Admin;

use App\Entity\JobGroup;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class JobGroupController extends AdminController
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
            view()->share('menuTop', 'jobs');
            return $next($request);
        });


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.job_group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.job_group.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'job_group_name' => 'unique:job_group'
        ],[
            'job_group_name.unique' => 'Nhóm việc làm bạn thêm đã có. Mời bạn thêm nhóm việc làm khác.'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            if($request->has('content')){
                $content = $request->input('content');
            }else{
                $content = '';
            }

            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('job_group_name'));
            }

            JobGroup::insert([
                'job_group_name' => $request->input('job_group_name'),
                'icon' => $request->input('icon'),
                'content' => $content,
                'slug' => $slug,
                'image' => $request->input('image'),
                'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu : Lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('job-group.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JobGroup $jobGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JobGroup $jobGroup)
    {
        return view('jobs.job_group.edit', compact('jobGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobGroup $jobGroup)
    {
        try{
            DB::beginTransaction();
            if($request->has('content')){
                $content = $request->input('content');
            }else{
                $content = '';
            }

            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('job_group_name'));
            }

            $jobGroup->update([
                'job_group_name' => $request->input('job_group_name'),
                'icon' => $request->input('icon'),
                'content' => $content,
                'slug' => $slug,
                'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'image' => $request->input('image'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập nhật dữ liệu : Lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('job-group.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobGroup $jobGroup)
    {
        try{
            DB::beginTransaction();
            $jobGroup->delete();

            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
            DB::rollBack();
        }finally{
            return redirect(route('job-group.index'));
        }
    }

    public function anyDatatable(){
        $jobGroups = JobGroup::select(
            'job_group_id',
            'job_group_name',
            'content',
            'total_jobs',
            'recruit',
            'recruited',
            'image'
        );

        return Datatables::of($jobGroups)
            ->addColumn('inventory', function ($jobGroup){
                $inventory = $jobGroup->recruit - $jobGroup->recruited;
                return $inventory;
            })
            ->addColumn('action', function ($jobGroup){
                $string = '<a href="' . route('job-group.edit',['job_group_id' => $jobGroup->job_group_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job-group.destroy', ['job_group_id' => $jobGroup->job_group_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('job_group_id','job_group_id desc')
            ->make(true);
    }
}
