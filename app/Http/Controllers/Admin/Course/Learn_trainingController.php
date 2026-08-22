<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_join_formality;
use App\Course\Course_tag;
use App\Course\Course_tag_id;
use App\Course\Courses;
use App\Entity\Teacher;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class Learn_trainingController extends AdminController
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
        $list_teacher = '';
//        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone')->get();
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $course = new Courses();
        $list_course = $course->select('courses.*', 'teacher.teacher_name', 'category_course.category_course_title', 'users.name')
            ->join('teacher', 'teacher.teacher_id', '=', 'courses.teacher_id')
            ->join('category_course', 'category_course.category_course_id', '=', 'courses.category_course_id')
            ->join('users', 'users.id', '=', 'courses.admin_id');
        if (!empty($request->input('category_course_id'))) {
            $list_course = $list_course->where('courses.category_course_id', $request->input('category_course_id'));
        }
        if (!empty($request->input('teacher_id'))) {
            $list_course = $list_course->where('courses.teacher_id', $request->input('teacher_id'));
        }
        if ($request->has('course_status')) {
            $list_course = $list_course->where('courses.course_status', $request->input('course_status'));
        }
        $list_course = $list_course->paginate(20);
        $list_course->appends(request()->query());
        return view('admin.course.courses.list', compact('list_course', 'list_teacher', 'list_category'));

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
        $list_tag = Course_tag::select('*')->get();
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

    public function ajax_check_courses_code(Request $request)
    {
        $courses_code = $request->input('courses_code');
        $course = new Courses();
        $check_course = $course->where('courses_code', $courses_code)->count();
        if (empty($check_course)) {
            return response([
                'message' => 'Mã khóa học này co thể sử dụng',
            ])->header('Content-Type', 'text/plain');
        } else {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function detail_course(Request $request, $course_id)
    {
        $course = new Courses();
        $course = $course->select('course_id',
            'course_title',
            'course_code')
            ->where('courses.course_id', $course_id)
            ->first();
        $course_chapters = new Course_chapters();
        $list_course_chapter = $course_chapters->select('*')->where('course_id', $course_id)->get();
        $total_course_chapter = $course_chapters->where('course_id', $course_id)->count();
        return view('admin.course.courses.detail', compact('course', 'list_course_chapter', 'total_course_chapter'));
    }


    public function store(Request $request)
    {
        $validation = $this->validateCourse($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký khóa học lỗi !')
                ->withInput();
        }
//        try {
        $courses_model = new Courses();
        $insert_id = $courses_model->insertGetId([
            'category_course_id' => $request->input('category_course_id'),
            'teacher_id' => $request->input('teacher_id'),
            'course_title' => $request->input('course_title'),
            'course_code' => $request->input('course_code'),
            'course_image' => $request->input('course_image'),
            'course_descript' => $request->input('course_descript'),
            'course_content' => $request->input('course_content'),
            'course_benefit' => $request->input('course_benefit'), //Lợi ích khóa học
            'activation_code' => $request->input('activation_code'), // mã kích hoạt khóa học mặc định
            'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
            'course_discount' => !empty($request->input('course_discount')) ? str_replace(".", "", $request->input('course_discount')) : 0,
            'admin_id' => Auth::user()->id, //user duyệt khóa học
            'course_status' => $request->input('course_status'),
            'created_at' => new \DateTime(),
        ]);
        $activation_code = Ultility::create_random_string(0, 6) . $insert_id;
        if (!empty($request->input('activation_code'))) {
            $activation_code = substr($request->activation_code . $insert_id, 0, 6);
        }
        $update_activation_code = $courses_model->where('course_id', $insert_id)->update([
            'activation_code' => $activation_code
        ]);
        $course_slug = Ultility::createSlug($request->input('course_title'));
//            echo $course_slug;die;

        $postWithSlug = $courses_model->where('course_slug', $course_slug)->first();
        if (empty($postWithSlug)) {
            $courses_model->where('course_id', '=', $insert_id)
                ->update([
                    'course_slug' => $course_slug
                ]);
        } else {
            $courses_model->where('course_id', '=', $insert_id)
                ->update([
                    'course_slug' => $course_slug . '-' . $insert_id
                ]);
        }
        if (!empty($request->input('tag_id'))) {
            $list_tag = $request->input('tag_id');
            foreach ($list_tag as $tag_id) {
                Course_tag_id::insertGetId([
                    'tag_id' => $tag_id,
                    'course_id' => $insert_id,
                    'created_at' => new \DateTime(),
                ]);
            }
        }

        return redirect('admin/courses')->with('success', 'Thêm khóa học thành công');
//        } catch (\Exception $exception) {
//            return redirect('admin/category_course')->with('error', 'Thên danh mục thất bại');
//        }

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
    public function edit($course_id)
    {
        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone')->get();
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('*')->get();
        $tags = Course_tag_id::select('*')->where('course_id', $course_id)->get();
        $tag = array();
        foreach ($tags as $t) {
            $tag[] = $t->tag_id;
        }
        $course = new Courses();
        $course = $course->select('courses.*')
            ->where('courses.course_id', $course_id)
            ->first();
        return view('admin.course.courses.edit', compact('list_teacher', 'list_category', 'course', 'list_tag', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $insert_id)
    {
        //
        $courses_model = new Courses();
        $update = $courses_model->where('course_id', $insert_id)->update([
            'category_course_id' => $request->input('category_course_id'),
            'teacher_id' => $request->input('teacher_id'),
            'course_title' => $request->input('course_title'),
            'course_code' => $request->input('course_code'),
            'course_image' => $request->input('course_image'),
            'course_descript' => $request->input('course_descript'),
            'course_content' => $request->input('course_content'),
            'course_benefit' => $request->input('course_benefit'), //Lợi ích khóa học
            'activation_code' => $request->input('activation_code'), // mã kích hoạt khóa học mặc định
            'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
            'course_discount' => !empty($request->input('course_discount')) ? str_replace(".", "", $request->input('course_discount')) : 0,
            'admin_id' => Auth::user()->id, //user duyệt khóa học
            'course_status' => $request->input('course_status'),
            'updated_at' => new \DateTime(),
        ]);
//        $activation_code = Ultility::create_random_string(0, 6) . $insert_id;
        if (!empty($request->input('activation_code'))) {
            $activation_code = substr($request->activation_code . $insert_id, 0, 6);
            $update_activation_code = $courses_model->where('course_id', $insert_id)->update([
                'activation_code' => $activation_code
            ]);
        }
        if (!empty($request->input('tag_id'))) {
            Course_tag_id::where('course_id', $insert_id)->delete();
            $list_tag = $request->input('tag_id');
            foreach ($list_tag as $tag_id) {
                Course_tag_id::insertGetId([
                    'tag_id' => $tag_id,
                    'course_id' => $insert_id,
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        return redirect('admin/courses')->with('success', 'Cập nhật khóa học thành công');
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

    public function list_formality($course_id)
    {
        $course = new Courses();
        $course = $course->select('courses.*')
            ->where('courses.course_id', $course_id)
            ->first();
        $list_formality = Course_join_formality::select('course_join_formality.*', 'course_formality.course_formality_title')
            ->join('course_formality', 'course_formality.course_formality_id', '=', 'course_join_formality.course_formality_id')
            ->get();
        $formality_id = array();
        foreach ($list_formality as $formality) {
            $formality_id[] = $formality->course_formality_id;
        }

        return view('admin.course.courses.list_formality', compact('course', 'list_formality', 'formality_id'));
    }

    public function store_formality(Request $request)
    {
//        echo $request->input('course_formality_id');die;
        if(!empty($request->input('course_formality_id')))
        {
            $insert = Course_join_formality::insert([
                'course_id' => $request->input('course_id'),
                'course_formality_id' => $request->input('course_formality_id'),
                'course_formality_price' => !empty($request->input('course_formality_price')) ? str_replace(".", "", $request->input('course_formality_price')) : 0,
                'course_formality_discount' => !empty($request->input('course_formality_discount')) ? str_replace(".", "", $request->input('course_formality_discount')) : 0,
                'course_formality_des' => $request->input('course_formality_des'),
                'created_at' => new \DateTime()
            ]);
            return redirect()->back()->with('success', 'Thêm hình thức học thành công');
        }
        return redirect()->back()->with('error', 'Hình thức học đã được tạo hết');
    }

    public function update_formality(Request $request)
    {
//        echo $request->input('course_join_formality_id');die;
        $course_formality_id = Course_join_formality::where('course_join_formality_id',$request->input('course_join_formality_id'))->value('course_formality_id');
        if(!empty($request->input('course_formality_id')))
        {
            $course_formality_id = $request->input('course_formality_id');
        }
        $update = Course_join_formality::where('course_join_formality_id',$request->input('course_join_formality_id'))->update([
            'course_formality_id' => $course_formality_id,
            'course_formality_price' => !empty($request->input('course_formality_price')) ? str_replace(".", "", $request->input('course_formality_price')) : 0,
            'course_formality_discount' => !empty($request->input('course_formality_discount')) ? str_replace(".", "", $request->input('course_formality_discount')) : 0,
            'course_formality_des' => $request->input('course_formality_des'),
            'updated_at' => new \DateTime()
        ]);
        return redirect()->back()->with('success', 'Cập nhật hình thức học thành công');
    }
    public function delete_formality($course_join_formality_id,Request $request)
    {
        $delete = Course_join_formality::where('course_join_formality_id',$course_join_formality_id)->delete();
        return redirect()->back()->with('success', 'Cập nhật hình thức học thành công');
    }


}
