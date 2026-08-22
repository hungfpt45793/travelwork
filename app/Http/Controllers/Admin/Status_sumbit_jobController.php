<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\Salary;
use App\Entity\Status_submit_job;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Status_sumbit_jobController extends AdminController
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
    public function index()
    {
        $status_submit_job = new Status_submit_job();
        $status_submit_job = $status_submit_job->select('*')->orderBy('id_status','asc')->get();
        return view('admin.status_submit_job.list',compact('status_submit_job'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.status_submit_job.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status_submit_job = new Status_submit_job();
        $status_submit_job = $status_submit_job->insert([
            'name_status' => $request->input('name_status'),
            'status_order' => $request->input('status_order')
        ]);
        return redirect(route('status_submit_job.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit($id_status)
    {
        $status_submit_job = new Status_submit_job();
        $status_submit_job = $status_submit_job->where('id_status',$id_status)->first();;
        return view('admin.status_submit_job.edit', compact('status_submit_job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_status)
    {
        $status_submit_job = new Status_submit_job();
        $status_submit_job = $status_submit_job->where('id_status',$id_status)->update([
            'name_status' => $request->input('name_status'),
            'status_order' => $request->input('status_order')
        ]);
        return redirect(route('status_submit_job.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_status)
    {

        try {
            DB::beginTransaction();
            $status_submit_job = new Status_submit_job();
            $status_submit_job = $status_submit_job->where('id_status',$id_status)->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('status_submit_job.index'));
        }
    }

}
