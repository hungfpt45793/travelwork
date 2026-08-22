<?php

namespace App\Http\Controllers\Admin;

use App\Exam\School_subject;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class School_subjectController extends AdminController
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
            view()->share('menuTop', 'teacher_school');
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
        $list_sub = School_subject::select('*')->get();
        return view('admin.school.subject.list',compact('list_sub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.subject.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'sub_code' => 'required|unique:school_subject',
            'sub_name' => 'required',
        ], [
            'sub_code.unique' => 'Mã môn học đã tồn tại.',
            'sub_code.required' => 'Mã môn học không được để trống.',
            'sub_name.required' => 'Tên môn học không được để trống',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $inser_sub = School_subject::insert([
               'sub_code' => $request->input('sub_code'),
               'sub_name' => $request->input('sub_name'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
            return redirect(route('school_subject.index'))->with('success', 'Thêm mới môn học thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('school_subject.index'))->with('error', 'Thêm mới môn học thất bại');
        }
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
    public function edit($sub_id)
    {
        $sub = School_subject::select('*')
            ->where('sub_id',$sub_id)->first();
        return view('admin.school.subject.edit', compact('sub'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sub_id)
    {
        try {
            DB::beginTransaction();
            $update_sub = School_subject::where('sub_id',$sub_id)->update([
                'sub_code' => $request->input('sub_code'),
                'sub_name' => $request->input('sub_name'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
            return redirect(route('school_subject.index'))->with('success', 'cập nhật môn học thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('school_subject.index'))->with('error', 'cập nhật môn học thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sub_id)
    {
        $update_sub = School_subject::where('sub_id',$sub_id)->delete();
        return redirect(route('school_subject.index'))->with('success', 'xóa môn học thành công');
    }
}
