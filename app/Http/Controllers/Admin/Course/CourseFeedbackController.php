<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_order;
use App\Course\Course_tag;
use App\Course\Courses;
use App\Entity\Teacher;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseFeedbackController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'educate');
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
        //
        $course_order = new Course_order();
        $list_order = $course_order->select('course_order.*','courses.course_title','courses.course_code','users.name');
        $list_order = $list_order->join('courses', 'courses.course_id', '=', 'course_order.course_id')
            ->join('users', 'users.id', '=', 'course_order.user_id');
        if($request->has('course_order_status'))
        {
            $list_order = $list_order->where('course_order.course_order_status', $request->input('course_order_status'));

        }
        if($request->has('activation_code'))
        {
            $list_order = $list_order->where('course_order.activation_code', $request->input('activation_code'));

        }
        if($request->has('course_title'))
        {
            $list_order = $list_order->where('courses.course_title','like', '%'.$request->input('course_title').'%');
        }
        $list_order = $list_order->orderBy('course_order.course_order_id', 'desc')
            ->paginate(20);
        $list_order->appends(request()->query());
        return view('admin.course.course_order.list', compact('list_order'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone')->get();
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('tag_id', 'tag_title')->get();
        return view('admin.course.courses.add', compact('list_teacher', 'list_category', 'list_tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function validateCourse($request)
    {
        $validation = Validator::make($request->all(), [
            'course_title' => 'required',
            'course_code' => 'required|unique:courses',
            'course_image' => 'required',
            'course_content' => 'required',
            'category_course_id' => 'required',
            'teacher_id' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'course_title.required' => 'Tiêu để không được để trống',
            'course_code.required' => 'Mã khóa học không được để trống',
            'course_code.unique' => 'Mã khóa học đã tồn tại',
            'course_image.required' => 'Hình ảnh không được bỏ trống',
            'category_course_id.required' => 'Vui lòng chọn danh mục',
            'teacher_id.required' => 'Vui lòng chọn giáo viên',

//            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        return $validation;
    }



    public function store(Request $request)
    {

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
    public function edit($course_order_id)
    {
        $course_order = new Course_order();
        $order = $course_order->select('course_order.*','courses.course_title','courses.course_code','users.name');
        $order = $order->join('courses', 'courses.course_id', '=', 'course_order.course_id')
            ->join('users', 'users.id', '=', 'course_order.user_id')
            ->where('course_order_id',$course_order_id)
            ->first();
        return view('admin.course.course_order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_order_id)
    {
        //
        $course_order = new Course_order();
        $update_order = $course_order->where('course_order_id',$course_order_id)->update([
            'admin_id' => Auth::user()->id,
            'course_order_status' => $request->input('course_order_status'),
            'admin_messager' => $request->input('admin_messager'),
            'updated_at' => new \DateTime()
        ]);
        return redirect('admin/course_order')->with('success', 'Cập nhật đơn hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id)
    {
        try {
            $courses_model = new Courses();
            $delete_id = $courses_model->where('course_id', $course_id)->delete();
            return redirect('admin/courses')->with('success', 'Xóa khóa học thành công');
        } catch (\Exception $exception) {
            return redirect('admin/courses')->with('error', 'Xóa khóa học thất bại');
        }
    }
}
