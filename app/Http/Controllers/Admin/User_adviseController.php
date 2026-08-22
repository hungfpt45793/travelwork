<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Age;
use App\Entity\Salary;
use App\Entity\Teacher_schools;
use App\Entity\User;
use App\Entity\User_advise;
use App\Entity\User_support_connect_advise;
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

class User_adviseController extends AdminController
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

        $list_ad = User_advise::select('user_advise.*', 'users.name', 'users.email', 'users.phone', 'users.role')
            ->join('users', 'users.id', '=', 'user_advise.user_id')
            ->orderBy('user_advise.ad_id', 'desc')
            ->get();
        return view('admin.school.user_advise.list', compact('list_ad'));
    }

    public function list_advise_connect($ad_id)
    {
        $list_ad = User_support_connect_advise::select('user_support_connect_advise.*', 'list_support.support_id', 'list_support.title_support', 'users.name', 'users.id', 'users.email', 'users.phone')
            ->join('list_support', 'list_support.support_id', 'user_support_connect_advise.support_id')
            ->join('users', 'users.id', 'user_support_connect_advise.user_id')
            ->where('user_support_connect_advise.ad_id', $ad_id)
            ->get();
        return view('admin.school.user_advise.list_advise_connect', compact('list_ad'));
    }

    public function update_advise_status(Request $request)
    {
        $connect_id = $request->input('connect_id');
        $update = User_support_connect_advise::where('connect_id', $connect_id)->update([
            'status_connect' => $request->input('status_connect')
        ]);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function list_user_suppotr_advise_connect()
    {
        $list_ad = User_support_connect_advise::select('user_support_connect_advise.*', 'list_support.support_id', 'list_support.title_support', 'users.name', 'users.id', 'users.email', 'users.phone')
            ->join('list_support', 'list_support.support_id', 'user_support_connect_advise.support_id')
            ->join('users', 'users.id', 'user_support_connect_advise.user_id')
            ->get();
        return view('admin.school.user_advise.list_user_suppotr_advise_connect', compact('list_ad'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.user_advise.add');
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
    public function edit($ad_id)
    {

        $user_advise = User_advise::select('user_advise.*', 'users.name', 'users.email', 'users.phone', 'users.role')
            ->join('users', 'users.id', '=', 'user_advise.user_id')
            ->where('user_advise.ad_id', $ad_id)
            ->first();

        return view('admin.school.user_advise.edit', compact('user_advise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ad_id)
    {

        $update = User_advise::where('ad_id', $ad_id)->update([
            'user_ad_status' => Auth::user()->id, //0 là không có ai duyệt
            'ad_status' => $request->input('ad_status'), //	0 là chưa duyêt, 1 là đã duyệt
            'updated_at' => new \DateTime()
        ]);
        return redirect(route('user_advise.index'))->with('success', 'Cập nhật thành công');


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

}
