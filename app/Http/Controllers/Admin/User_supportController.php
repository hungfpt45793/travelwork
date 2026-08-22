<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Age;
use App\Entity\Salary;
use App\Entity\Teacher_schools;
use App\Entity\User;
use App\Entity\User_support;
use App\Entity\User_support_connect_advise;
use App\Entity\User_support_question;
use App\Exam\Detail_result_school;
use App\Exam\Exam_school;
use App\Exam\Exam_school_question_school;
use App\Exam\Questions_school;
use App\Exam\Result_school;
use App\Exam\Room_school;
use App\Exam\Student_school;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class User_supportController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

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

        $list_sup = User_support::select('user_support.*', 'users.name', 'users.email', 'users.phone', 'users.role')
            ->join('users', 'users.id', '=', 'user_support.user_id')
            ->orderBy('user_support.sup_id', 'desc')
            ->get();
        return view('admin.school.user_support.list', compact('list_sup'));
    }


    public function list_support_connect($sup_id)
    {

        $list_ad = User_support_question::select('user_support_question.*', 'list_support.support_id', 'list_support.title_support')
            ->join('list_support', 'list_support.support_id', 'user_support_question.support_id')
//            ->join('users', 'users.id', 'user_support_question.user_id')
            ->where('user_support_question.sup_id', $sup_id)
            ->get();
        return view('admin.school.user_support.list_sup_connect', compact('list_ad'));
    }

    public function update_support_status(Request $request)
    {
        $ques_id = $request->input('ques_id');
        $update = User_support_question::where('ques_id', $ques_id)->update([
            'ques_status' => $request->input('ques_status')
        ]);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.teacher.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        'teacher_sc_id',
//        'teacher_sc_name',
//        'teacher_sc_email',
//        'teacher_sc_phone',
//        'user_id',
//        'created_at',
//        'updated_at',
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'teacher_sc_name' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 6 ký tự.',
            'teacher_sc_name.required' => 'Tên giáo viên không được bỏ trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $userModel = new User();
            $user_id_create = $userModel->insertGetId([
                'name' => $request->input('teacher_sc_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('teacher_sc_phone') ? $request->input('teacher_sc_phone') : '',
                'role' => 3,
                'status_teacher_sc' => 1
            ]);
            $teacher = new Teacher_schools();
            $insert = $teacher->insertGetId([
                'teacher_sc_name' => $request->input('teacher_sc_name'),
                'teacher_sc_phone' => $request->input('teacher_sc_phone'),
                'teacher_sc_email' => $request->has('email') ? $request->input('email') : '',
                'user_id' => $user_id_create,
                'logo_teacher' => $request->input('image'),
                'teacher_school' => $request->input('teacher_school'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
            return redirect(route('teacher_school.index'))->with('success', 'Thêm mới giáo viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('teacher_school.index'))->with('error', 'Thêm mới giáo viên thất bại');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function edit($teacher_sc_id)
    {
        $teacher_school = Teacher_schools::select('*')
            ->join('users', 'users.id', '=', 'teacher_schools.user_id')
            ->where('teacher_sc_id', $teacher_sc_id)->first();
        return view('admin.school.teacher.edit', compact('teacher_school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $teacher_sc_id)
    {
        $teacher_school = Teacher_schools::select('*')
            ->join('users', 'users.id', '=', 'teacher_schools.user_id')
            ->where('teacher_sc_id', $teacher_sc_id)->first();


        $validation = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'teacher_sc_name' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu Phải lớn hơn 6 ký tự.',
            'teacher_sc_name.required' => 'Tên giáo viên không được bỏ trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $userModel = new User();
            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $update = $userModel->where('id', $teacher_school->user_id)->update([
                    'password' => bcrypt($request->input('password')),
                    'status_teacher_sc' => 1
                ]);
            }
            $update_user = $userModel->where('id', $teacher_school->user_id)->update([
                'name' => $request->input('teacher_sc_name'),
                'phone' => $request->has('teacher_sc_phone') ? $request->input('teacher_sc_phone') : '',
                'status_teacher_sc' => 1
            ]);

            $update_teacher = Teacher_schools::where('teacher_sc_id', $teacher_sc_id)->update([
                'teacher_sc_name' => $request->input('teacher_sc_name'),
                'teacher_sc_phone' => $request->input('teacher_sc_phone'),
                'logo_teacher' => $request->input('image'),
                'teacher_school' => $request->input('teacher_school'),
                'updated_at' => new \DateTime()
            ]);
//        return redirect(route('teacher.index'))->with('success','Thêm mới giáo viên thành công');

            DB::commit();
            return redirect(route('teacher_school.index'))->with('success', 'Cập nhật giáo viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('teacher_school.index'))->with('error', 'Cập nhật giáo viên thất bại');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($teacher_sc_id)
    {

//        try {
//            DB::beginTransaction();
        //cân xu ly xóa them các bang liên quan dến giáo viên

        $teacher = Teacher_schools::where('teacher_sc_id', $teacher_sc_id)->first();
        $user_model = new User();
        $delete_user = $user_model->where('id', $teacher->user_id)->delete();
        $user = $user_model->onlyTrashed()->where('id', $teacher->user_id)->first();

        $user_model->withTrashed()->where('id', $teacher->user_id)->forceDelete();


        //xóa đề thi
        $delete_exam_school = Exam_school::where('teacher_sc_id', $teacher_sc_id)->delete();
        //xoa sư thi và cau hỏi đề thi
        $delete_exam_question_school = Exam_school_question_school::where('teacher_sc_id', $teacher_sc_id)->delete();
        //xóa câu hỏi
        $delete_question = Questions_school::where('teacher_sc_id', $teacher_sc_id)->delete();
//            xóa thông tin ;liên quan đền phong thi giao viên tạo
        //xóa phòng thi
        $list_room = Room_school::where('teacher_sc_id', $teacher_sc_id)->get();
        foreach ($list_room as $room) {
            $result_room = Result_school::where('id_room', $room->id_room)->get();
            foreach ($result_room as $result) {
                //xóa ung vien thi
                $delete_student = Student_school::where('student_id', $result->id_student)->delete();
                //xoa chi tiet kết quả thi
                $delete_detail_result_room = Detail_result_school::where('id_result', $result->id_result)->delete();
            }
//                xoa ket qua thi
            $result_room = Result_school::where('id_room', $room->id_room)->delete();
            //xoa phong thi
            $delete_room = Room_school::where('teacher_sc_id', $teacher_sc_id)->delete();
        }
        $delete_teacher = Teacher_schools::where('teacher_sc_id', $teacher_sc_id)->delete();
        DB::commit();
        return redirect(route('teacher_school.index'))->with('success', 'xóa giáo viên thành công');
//        } catch(\Exception $exception) {
//            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
//            DB::rollBack();
//        }finally{
//            return redirect(route('teacher_school.index'))->with('success', 'xóa giáo viên thành công');
//        }
    }

    public function list_user_suppotr_question()
    {
        $list_sup = User_support_question::select('user_support_question.*','list_support.title_support')
            ->join('list_support', 'list_support.support_id', '=', 'user_support_question.support_id')
            ->join('user_support', 'user_support.sup_id', '=', 'user_support_question.sup_id')
            ->orderBy('user_support_question.ques_id', 'desc')
            ->get();
        return view('admin.school.user_support.list_question', compact('list_sup'));
    }

    public function detail_question($ques_id)
    {

    }

    public function update_detail_question($ques_id, Request $request)
    {
         $update = User_support_question::where('ques_id',$ques_id)->update([
             'status_show' => $request->input('status_show')
         ]);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

}
