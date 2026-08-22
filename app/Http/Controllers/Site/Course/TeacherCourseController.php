<?php

namespace App\Http\Controllers\Site\Course;

use App\Course\Category_course;
use App\Course\Course;

use App\Course\Course_chapter_contents;
use App\Course\Course_chapters;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_employee;
use App\Course\Course_employee_status;
use App\Course\Course_feedback;
use App\Course\Course_formality;
use App\Course\Course_join_formality;
use App\Course\Course_order;
use App\Course\Course_questions;
use App\Course\Course_statistical_teacher;
use App\Course\Course_status_voucher;
use App\Course\Course_teacher_active;
use App\Course\Course_teacher_money;
use App\Course\Courses;
use App\Entity\Employee;
use App\Http\Controllers\Site\CkedittorController;
use App\Http\Controllers\Site\SiteController;
use App\Entity\Teacher;

use App\Ultility\Ultility;
use Cassandra\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherCourseController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check() && Auth::user()->role != 3) {
                return redirect('/');
            }
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            view()->share('menuTopsite', 'teacher');
            return $next($request);
        });
    }

    //danh sach khoa hoc
    public function list_teacher_courses(Request $request)
    {
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $list_course = Courses::select('course_id',
            'teacher_id',
            'course_title',
            'course_code',
            'course_slug',
            'course_image',
            'course_price',
            'course_discount',
            'admin_id', //user duyệt khóa học
            'course_status',
            'course_views',
            'course_formality_id', // = 1 trạng thái tự học
            'created_at',
            'updated_at')
            ->where('teacher_id', $teacher->teacher_id)
            ->orderBy('teacher_id', 'desc')
            ->paginate(10);
        return view('site.teacher_course_site.list_teacher_courses', compact('list_course'));
    }

    //thong ke khao hoc
    public function list_static_courses()
    {
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $teacher_money = Course_teacher_money::where('teacher_id', $teacher->teacher_id)->first();

        $list_statistical = Course_order::select('course_order.course_order_id',
            'course_order.course_id',
            'course_order.course_formality_id',//hinh thuc học
            'course_order.course_cost',  //giá của khóa học
            'course_order.course_order_status', //trạng thái thanh toán của khóa hoc: 0 là chưa, 1 đã thanh toán
            'course_order.admin_id',
            'course_order.employee_id', //ung vien chia se bai viet
            'course_order.admin_messager',
            'course_order.activation_code',  //mã kích hoạt
            'course_order.activation_code_status', //trạng thái mã kích hoạt 0 là chưa 1 là đã sử dụng
            'course_order.course_name',
            'course_order.course_phone',
            'course_order.course_email',
            'courses.course_code',
            'courses.course_title',
            'courses.course_slug',
            'course_order.learn_id',
            'course_order.created_at',
            'course_order.updated_at'
        )
            ->join('courses', 'courses.course_id', '=', 'course_order.course_id')
            ->where('courses.teacher_id', $teacher->teacher_id)
            ->orderBy('course_order.course_order_id', 'desc')
            ->distinct('course_order.course_order_id')
            ->paginate(20);

        return view('site.teacher_course_site.list_teacher_static', compact('teacher_money', 'list_statistical'));

    }

    //danh sahc cua hoi cua khoa
    public function list_teacher_question()
    {
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $list_question = Course_questions::select(
            'course_questions.course_comments_id',
            'course_questions.course_comments_content',
            'course_questions.user_id',
            'course_questions.course_id',
            'course_questions.course_comments_status',
            'course_questions.parent_course_comments_id',
            'users.name',
            'courses.course_code',
            'courses.course_title',
            'courses.course_slug',
            'course_questions.created_at'
        )->join('courses', 'courses.course_id', '=', 'course_questions.course_id')
            ->join('users', 'users.id', '=', 'course_questions.user_id')
            ->where('courses.teacher_id', $teacher->teacher_id)
            ->orderBy('course_questions.course_comments_id', 'desc')
            ->where('course_questions.parent_course_comments_id', 0)
            ->paginate(20);
        return view('site.teacher_course_site.list_teacher_question', compact('list_question'));

    }

    public function detail_teacher_question($course_comments_id)
    {
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $question = Course_questions::select(
            'course_questions.course_comments_id',
            'course_questions.course_comments_content',
            'course_questions.user_id',
            'course_questions.course_id',
            'course_questions.course_comments_status',
            'course_questions.parent_course_comments_id',
            'users.name',
            'users.image',
            'courses.course_code',
            'courses.course_title',
            'courses.course_slug',
            'course_questions.created_at'
        )->join('courses', 'courses.course_id', '=', 'course_questions.course_id')
            ->join('users', 'users.id', '=', 'course_questions.user_id')
            ->where('courses.teacher_id', $teacher->teacher_id)
            ->where('course_questions.parent_course_comments_id', 0)
            ->where('course_questions.course_comments_id', $course_comments_id)
            ->first();

        $list_question = Course_questions::select(
            'course_questions.course_comments_id',
            'course_questions.course_comments_content',
            'course_questions.user_id',
            'course_questions.course_id',
            'course_questions.course_comments_status',
            'course_questions.parent_course_comments_id',
            'users.name',
            'courses.course_code',
            'courses.course_title',
            'courses.course_slug',
            'course_questions.created_at'
        )->join('courses', 'courses.course_id', '=', 'course_questions.course_id')
            ->join('users', 'users.id', '=', 'course_questions.user_id')
            ->where('courses.teacher_id', $teacher->teacher_id)
            ->where('course_questions.parent_course_comments_id', $course_comments_id)
            ->get();

        return view('site.teacher_course_site.detail_teacher_question', compact('question', 'list_question'));
    }

    public function store_question_answer(Request $request)
    {
        $insert_question = Course_questions::insert([
            'course_comments_content' => $request->input('course_comments_content'),
            'user_id' => Auth::user()->id,
            'course_id' => $request->input('course_id'),
            'parent_course_comments_id' => $request->input('parent_course_comments_id'),
            'created_at' => new \DateTime(),
        ]);
        return redirect()->back()->with('mesage_modal', 'Gửi câu trả lời thành công');
    }

    public function list_courses_active($course_id)
    {
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $course = Courses::where('course_id', $course_id)
            ->where('teacher_id', $teacher->teacher_id)
            ->first();
        $list_active = Course_teacher_active::select('*')->where('course_id', $course_id)->get();
        return view('site.teacher_course_site.list_courses_active', compact('list_active', 'course'));
    }

    public function create_courses_active(Request $request)
    {
        $course_id = $request->input('course_id');
        $teacher = Teacher::getTeacher_id(Auth::user()->id);
        $course = Courses::where('course_id', $course_id)
            ->where('teacher_id', $teacher->teacher_id)
            ->first();

        $check_active_count = Course_teacher_active::where('teacher_id', $teacher->teacher_id)
            ->where('course_id', $course_id)
            ->count();
        if (!empty($check_active_count)) {
            return redirect(route('list_courses_active', ['course_id' => $course_id]));
        }
        //mỗi khóa học dc tạo miễn phí 20 mã
        $today = date('Y-m-d');
        $date_end_active = strtotime(date("Y-m-d", strtotime($today)) . " +6 month");
        $date_end_active = strftime("%Y-%m-%d", $date_end_active);
//        echo $date_end_active;die;
        $total_max = 20;
        for ($i = 1; $i <= $total_max; $i++) {
            $random = Ultility::create_random_string(0, 5);
            $course_active = $i.$random;
            $ccurse_teacher_model = new Course_teacher_active();
            $course_teacher_id = $ccurse_teacher_model->insertGetId([
                'teacher_id' => $teacher->teacher_id,
                'course_id' => $course_id,
                'activation_code' => $course_active,
                'date_end_active' => $date_end_active,
                'status_active_code' => 0,
                'created_at' => new \DateTime()
            ]);
            $update = $ccurse_teacher_model->where('course_teacher_id',$course_teacher_id)
                ->update([
                    'activation_code' => $course_active.$course_teacher_id,
                    'updated_at' => null
                ]);
        }
        return redirect(route('list_courses_active', ['course_id' => $course_id]));
    }

}
