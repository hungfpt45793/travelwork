<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SalaryController extends AdminController
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

            view()->share('menuTop', 'setting');

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
		$salary = Salary::get();
        return view('admin.salary.list',compact('salary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.salary.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
           Salary::insert([
               'salary_from' => $request->input('salary_from'),
               'salary_to' => $request->input('salary_to'),
              'status_salary' => !empty($request->input('status_salary')) ? $request->input('status_salary') : 0,
               'description' => $request->has('description') ? $request->input('description') : ''
           ]);
           DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể thêm mới dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        } finally {
            return redirect(route('salary.index'));
        }
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
    public function edit(Salary $salary)
    {
        return view('admin.salary.edit', compact('salary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        try {
            DB::beginTransaction();
            $salary->update([
                'salary_from' => $request->input('salary_from'),
                'salary_to' => $request->input('salary_to'),
                'status_salary' => !empty($request->input('status_salary')) ? $request->input('status_salary') : 0,
                'description' => $request->has('description') ? $request->input('description') : ''
            ]);
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('salary.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {

        try {
            DB::beginTransaction();
            $salary->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('salary.index'));
        }
    }

    public function anyDatatable(){
        $salaries = Salary::select(
        'salary_id',
            'salary_from',
            'salary_to',
            'status_salary',
            'description'
        );
        return Datatables::of($salaries)
            ->addColumn('action', function ($salary){
                $string = '<a href="' . route('salary.edit',['salary_id' => $salary->salary_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('salary.destroy', ['salary_id' => $salary->salary_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('salary_id','salary_id desc')
            ->make(true);
    }
}
