<?php

namespace App\Http\Controllers\Site\Course;

use App\Course\Course;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use App\Entity\Invite;
use App\Entity\MailConfig;
use App\Entity\SettingGetfly;
use App\Entity\Teacher;
use App\Entity\Template;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employer;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTypeBusiness;
use App\Entity\NoteEmployer;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class CourseController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng dăng nhập để sử dụng chức năng này !');
            }
            $this->id_user = Auth::user()->id;
            return $next($request);
        });
    }
//    check quyền nhà tuyển dụng
    private function checkRoleUser()
    {
        $role = Auth::user()->role;
        if ($role == 3) {
            return true;
        } else {
            return false;
        }
    }
    public function index()
    {

        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành giáo viên để tạo khóa học !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $teacher = new Teacher();
        $teacher = $teacher->select('teacher_id')->where('user_id',$user_id)->first();
        $course = new Course();
        $list_course = $course->select('*')->where('teacher_id',$teacher->teacher_id)->orderBy('course_id','desc')->paginate(15);
        return view('site.course_admin_site.list_course',compact('user','list_course'));
    }
    public function create(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành giáo viên để tạo khóa học !');
        }
        $user = Auth::user();
        return view('site.course_admin_site.add_course', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành giáo viên để tạo khóa học !');
            }
            $user = Auth::user();
            $validation = Validator::make($request->all(), [
                'course_name' => 'required',
                'images' => 'required',
                'course_intro' => 'required',
                'course_price' => 'required',
                'course_time' => 'required',
                'g-recaptcha-response' => 'required',
            ], [
                'course_name.required' => 'Tên khóa học không được bỏ trống',
                'images.required' => 'Ảnh mô tả không được bỏ trống',
                'course_intro.required' => 'Giới thiệu không được bỏ trống',
                'course_price.required' => 'Giá khóa học không được để trống',
                'course_time.required' => 'Thời gian về khóa học không được để trống',
                'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
            ]);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withErrors($validation)
                    ->withInput();
            }
            $user_id = Auth::user()->id;

            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id')->where('user_id', $user_id)->first();

            $course = new Course();
            $slug = Ultility::createSlug($request->input('course_name'));

            $course_id = $course->insertGetId([
                'course_name' => $request->input('course_name'),
                'course_image' => $request->input('course_image'),
                'course_intro' => $request->input('course_intro'),
                'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
                'course_time' => $request->input('course_time'),
                'course_image' => $request->has('images') ? $request->input('images') : '',
                'teacher_id' => $teacher->teacher_id,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            ]);
            $this->code_exam($course_id);
            // insert slug
            $jobWithSlug = $course->where('slug', $slug)->first();
            if (empty($jobWithSlug)) {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug . '-' . $course_id
                    ]);
            }
            return redirect(route('course.index'))->with('suscess', 'Thêm mới khóa học thành công');
        }
        catch(\Exception $exception)
        {
            return redirect(route('course.index'))->with('erorr', 'Thêm khóa học thất bại');
        }
    }
    public function edit(Request $request ,$course_id)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành giáo viên để tạo khóa học !');
        }
        $course = new Course();
        $cours = $course->select('*')->where('course_id',$course_id)->first();

        $user = Auth::user();
        return view('site.course_admin_site.edit_course', compact('user','cours'));
    }
    public function update(Request $request ,$course_id)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành giáo viên để tạo khóa học !');
        }
        $user = Auth::user();
        $validation = Validator::make($request->all(), [
            'course_name' => 'required',
            'images' => 'required',
            'course_intro' => 'required',
            'course_price' => 'required',
            'course_time' => 'required',
            'g-recaptcha-response' =>   'required',
        ], [
            'course_name.required' => 'Tên khóa học không được bỏ trống',
            'images.required' => 'Ảnh mô tả không được bỏ trống',
            'course_intro.required' => 'Giới thiệu không được bỏ trống',
            'course_price.required' => 'Giá khóa học không được để trống',
            'course_time.required' => 'Thời gian về khóa học không được để trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $user_id = Auth::user()->id;

        try {
            $course = new Course();
            $slug = Ultility::createSlug($request->input('course_name'));

            $update = $course->where('course_id', $course_id)->update([
                'course_name' => $request->input('course_name'),
                'course_image' => $request->input('course_image'),
                'course_intro' => $request->input('course_intro'),
                'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
                'course_time' => $request->input('course_time'),
                'course_image' => $request->has('images') ? $request->input('images') : '',
                'updated_at' => new \DateTime(),

            ]);
            // insert slug
            $jobWithSlug = $course->where('slug', $slug)->first();
            if (empty($jobWithSlug)) {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug . '-' . $course_id
                    ]);
            }
            return redirect(route('course.index'))->with('suscess', 'Sửa khóa học thành công');
        } catch(\Exception $exception)
        {
            return redirect(route('course.index'))->with('erorr', 'Sửa khóa học thất bại');
        }
    }
    public function destroy(Request $request ,$course_id)
    {
        try{
            $course = new Course();
            $update = $course->where('course_id',$course_id)->delete();
            return redirect(route('course.index'))->with('suscess', 'Xóa khóa học thành công');
        }
        catch(\Exception $exception)
        {
            return redirect(route('course.index'))->with('erorr', 'Xóa khóa học thất bại');
        }

    }
    public function code_exam($course_id)
    {
        $id_course = intval($course_id);
        $course_code = 'KH' . ($id_course + 100);
        Course::where('course_id', $course_id)->update([
            'course_code' => $course_code,
        ]);
    }

}
