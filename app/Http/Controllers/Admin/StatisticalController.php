<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Evaluate;
use App\Entity\NoteEmployee;
use App\Entity\Salary;
use App\Entity\Statistical_employees;
use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Software;
use App\Entity\Career;
use App\Entity\Job;
use App\Entity\EmployeeSoftware;
use App\Entity\EmployeeCareerCategories;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class StatisticalController extends AdminController
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

            view()->share('menuTop', 'customers');

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


        $statiscal_employee = new Statistical_employees();
        $statiscal = $statiscal_employee->select('statistical_employees.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone')->leftJoin('employees', 'employees.employee_id', '=', 'statistical_employees.employees_id');
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $statiscal = $statiscal->where('employees.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('phone'))) {
            $phone = $request->input('phone');
            $statiscal = $statiscal->where('employees.phone', 'like', '%' . $phone . '%');
        }
        if (!empty($request->input('phone'))) {
            $name = $request->input('name');
            $statiscal = $statiscal->where('employees.employee_name', 'like', '%' . $name . '%');
        }

        if (!empty($request->input('money'))) {
            $money = $request->input('money');
            $statiscal = $statiscal->orderBy('money', $money);
        }
        if (!empty($request->input('total_teacher'))) {
            $total_teacher = $request->input('total_teacher');
            $statiscal = $statiscal->orderBy('total_teacher', $total_teacher);
        }

        if (!empty($request->input('total_exam'))) {
            $total_exam = $request->input('total_exam');
            $statiscal = $statiscal->orderBy('total_exam', $total_exam);
        }
        if (!empty($request->input('total__dowload_voucher'))) {
            $total__dowload_voucher = $request->input('total__dowload_voucher');
            $statiscal = $statiscal->orderBy('total__dowload_voucher', $total__dowload_voucher);
        }
        if (!empty($request->input('total_view_voucher'))) {
            $total_view_voucher = $request->input('total_view_voucher');
            $statiscal = $statiscal->orderBy('total_view_voucher', $total_view_voucher);
        }
        if (!empty($request->input('total_view_job'))) {
            $total_view_job = $request->input('total_view_job');
            $statiscal = $statiscal->orderBy('total_view_job', $total_view_job);
        }
        if (!empty($request->input('total_cv'))) {
            $total_cv = $request->input('total_cv');
            $statiscal = $statiscal->orderBy('total_cv', $total_cv);
        }
        $statiscal = $statiscal->orderBy('id_statistical');
        $statiscal = $statiscal->paginate(50);

        $total = $statiscal->count();
        return view('customers.statiscal_employee.list', compact('statiscal', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = new Employee();
        $employees = $employees->select('employee_id', 'employee_name', 'email', 'phone')->leftJoin('statistical_employees', 'statistical_employees.employees_id', '=', 'employees.employee_id')->get();
        return view('customers.statiscal_employee.add', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employees_id' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'employees_id.required' => 'Vui lòng chọn ứng viên',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            $statiscal_employee = new Statistical_employees();
            $statiscal_employee = $statiscal_employee->insert([
                'employees_id' => $request->input('employees_id'),
                'money' => !empty($request->input('money')) ? str_replace(".", "", $request->input('money')) : 0,
                'total_teacher' => $request->input('total_teacher'),
                'total_exam' => $request->input('total_exam'),
                'total__dowload_voucher' => $request->input('total__dowload_voucher'),
                'total_view_voucher' => $request->input('total_view_voucher'),
                'total_view_job' => $request->input('total_view_job'),
                'total_cv' => $request->input('total_cv'),
                'created_at' => new \DateTime()
            ]);
            return redirect(route('statiscal.index'))->with('success', 'Thêm thống kê thành công');
        } catch (\Exception $ex) {
            return redirect(route('statiscal.index'))->with('error', 'Thêm thống kê thất bại');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_statistical)
    {
        $employees = new Employee();
        $employees = $employees->select('employee_id', 'employee_name', 'email', 'phone')->get();

        $statiscal = new Statistical_employees();
        $statiscal = $statiscal->select('*')->where('id_statistical', $id_statistical)->first();
        return view('customers.statiscal_employee.edit', compact('employees', 'statiscal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_statistical)
    {
        try {
            $statiscal_employee = new Statistical_employees();
            $statiscal_employee = $statiscal_employee->where('id_statistical', $id_statistical)->update([
                'money' => !empty($request->input('money')) ? str_replace(".", "", $request->input('money')) : 0,
                'total_teacher' => $request->input('total_teacher'),
                'total_exam' => $request->input('total_exam'),
                'total__dowload_voucher' => $request->input('total__dowload_voucher'),
                'total_view_voucher' => $request->input('total_view_voucher'),
                'total_view_job' => $request->input('total_view_job'),
                'total_cv' => $request->input('total_cv'),
            ]);
            return redirect(route('statiscal.index'))->with('success', 'Sửa thống kê thành công');
        } catch (\Exception $ex) {
            return redirect(route('statiscal.index'))->with('error', 'Sửa thống kê thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_statistical)
    {
        try {
            $statiscal_employee = new Statistical_employees();
            $statiscal_employee = $statiscal_employee->where('id_statistical', $id_statistical)->delete();

            return redirect(route('statiscal.index'))->with('success', 'Xóa thống kê thành công');
        } catch (\Exception $exception) {
            return redirect(route('statiscal.index'))->with('error', 'Xóa thống kê thất bại');
        }
    }

}
