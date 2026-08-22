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
use App\Course\Course_status_voucher;
use App\Course\Course_tag;
use App\Course\Course_tag_id;
use App\Course\Courses;
use App\Course\Detail_result_question_course;
use App\Course\Questions_course_chapter_contents;
use App\Course\Detailresult_question_course;
use App\Course\Result_question_course;
use App\Entity\Employee;
use App\Entity\Learn_training;
use App\Entity\Training;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\SiteController;
use App\Entity\Teacher;
use App\Ultility\Ultility;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoursesController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'teacher');
    }

    public function index(Request $request)
    {
//        echo $request->session()->get('activation_code');die;
        try {
            $cate_course = new Category_course();
            $course_categorise = $cate_course->select(
                'category_course_id',
                'category_course_title',
                'category_course_slug',
                'category_course_desc'
            )
                ->limit(12)
                ->get();

            $all_cate = [
                'category_course_id' => -1,
                'category_course_title' => 'Tất cả',
                'category_course_slug' => 'tat-ca-khoa-hoc',
                'category_course_desc' => 'tất cả danh mục'
            ];

            $all_course = Courses::getCourse_category_slug($all_cate['category_course_slug']);
            $list_course[$all_cate['category_course_slug']] = $all_course;
            $courseFeedbackModel = new Course_feedback();

            foreach ($course_categorise as $course_cate) {
                $courses = Courses::getCourse_category_slug($course_cate['category_course_slug']);
                $list_course[$course_cate['category_course_slug']] = $courses;
            }

            return view('site.course_site.list_course', compact('course_categorise', 'all_cate', 'list_course'));

        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    public function categoryCourse($category_slug = 'tat-ca-khoa-hoc')
    {
        try {
            if ($category_slug == 'tat-ca-khoa-hoc') {
                $course_categorise['category_course_title'] = 'Tất cả';
                $courseModel = new Courses();
                $courses = $courseModel
                    ->select(
                        'courses.course_id',
                        'courses.course_title',
                        'courses.course_slug',
                        'courses.course_image',
                        'courses.course_descript',
                        'courses.course_content',
                        'courses.course_views',
                        'courses.course_price',
                        'courses.course_discount',
                        'teacher.teacher_name',
                        'teacher.slug',
                        'teacher.teacher_images'
                    )
                    ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                    ->where('courses.course_status', 1)
                    ->orderBy('courses.course_id', 'desc')
                    ->paginate(12);
            } else {
                $cate_course = new Category_course();
                $course_categorise = $cate_course->select(
                    'category_course_id',
                    'category_course_title',
                    'category_course_slug',
                    'category_course_desc'
                )
                    ->where('category_course_slug', $category_slug)
                    ->first();
                $courseModel = new Courses();
                $courses = $courseModel
                    ->select(
                        'courses.course_id',
                        'courses.course_title',
                        'courses.course_slug',
                        'courses.course_image',
                        'courses.course_descript',
                        'courses.course_content',
                        'courses.course_views',
                        'courses.course_price',
                        'courses.course_discount',
                        'teacher.teacher_name',
                        'teacher.slug',
                        'teacher.teacher_images'
                    )
                    ->where('category_course_id', $course_categorise['category_course_id'])
                    ->where('courses.course_status', 1)
                    ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                    ->orderBy('courses.course_id', 'desc')
                    ->paginate(12);
            }

            return view('site.course_site.category_course', compact('course_categorise', 'courses'));

        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    public function showCourseDetail($course_slug)
    {
        $course = Courses::where('course_slug', $course_slug)
            ->select(
                'courses.course_id',
                'courses.course_title',
                'courses.course_code',
                'courses.course_benefit',
                'courses.course_slug',
                'courses.course_image',
                'courses.course_views',
                'courses.course_descript',
                'courses.course_content',
                'courses.course_price',
                'courses.course_discount',
                'courses.created_at',
                'courses.updated_at',
                'courses.course_formality_id',
                'courses.teacher_id',
                'title_detail1',  //⦁	Đăng ký học ngay -> Đăng ký tham gia nhóm
                'title_detail2', //⦁	 Sở hữu khóa học trọn đời -> Phí thành viên đóng linh hoạt
                'title_detail3', //⦁	 Khoá học này dành cho -> Nhóm Facebook này dành cho
                'title_detail4', //⦁	 Bạn sẽ nhận được gì nếu đăng ký khóa học này -> Bạn sẽ nhận được gì nếu tham gia nhóm Facebook này
                'title_detail5' //⦁	 Nội dung khoá học -> Những nội dung được hỗ trợ trả lời trong nhóm
            )
            ->where('course_status', 1)
            ->first();
        if (empty($course))
            return view('site.course_site.error_course_404');

        Courses::where('course_slug', $course_slug)->update(['course_views' => $course['course_views'] + 1]);

//        $total_employee = Course_employee::where('course_id', $course->course_id)->count();
        $total_employee = Course_order::where('course_id',$course->course_id)->count();
        $rating = Course_feedback::getRatings($course['course_slug']);
        $course['star'] = $rating['star'];
        $course['total_feedback'] = $rating['total_feedback'];
        $teacher = Teacher::getTeacherDetail($course['slug']);
//        echo $course['courses_id'];die;
        $course_min_price = Learn_training::where('courses_id', $course->course_id)
            ->orderBy('learn_discount', 'asc')
            ->first();
//        echo '<pre>';
//        print_r($course);die;
        return view('site.course_site.detail_course', compact('course', 'total_employee', 'course_min_price'));
    }

    public function myCourse()
    {
        try {
            if (!Auth::check())
                return redirect()->route('home')->with('mesage_modal', 'bạn cần đăng nhập đễ xem nội dung này');
            $employee_id = Employee::where('user_id', Auth::id())->value('employee_id');
//            echo $employee_id;die;
            $courseEmployeeModel = new Course_employee();
            $courses = $courseEmployeeModel
                ->select('courses.course_id',
                    'courses.course_title',
                    'courses.course_slug',
                    'courses.course_image',
                    'courses.course_views',
                    'courses.course_descript',
                    'courses.course_content',
                    'courses.course_price',
                    'courses.course_discount',
                    'teacher.teacher_name',
                    'teacher.slug',
                    'teacher.teacher_images'
                )
                ->where('employee_id', $employee_id)
                ->join('courses', 'courses.course_id', 'course_employee.course_id')
                ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                ->get();

//            echo '<pre>';
//            print_r($employee_id);die;
            foreach ($courses as $course_loop_id => $course) {
                $courses[$course_loop_id]['total_employee'] = $courseEmployeeModel->where('course_id', $course->course_id)
                    ->count();
                $star = Course_feedback::where('employee_id', $employee_id)
                    ->where('course_id', $course['course_id'])
                    ->first();
                if (isset($star))
                    $star = $star->ratings;
                $courses[$course_loop_id]['star'] = $star;
            }
            return view('site.course_site.my_course', compact('courses', 'employee_id'));
        } catch (\Exception $e) {
            return view('site.course_site.error_course_404');
        }
    }

    public function payment(Request $request, $course_slug)
    {
        $course_formality_id = 1;
        if ($request->has('course_formality_id')) {
            $course_formality_id = $request->input('course_formality_id');
        }
        if ($course_formality_id == 1) {
            $courses = Courses::select('courses.course_code',
                'courses.course_id',
                'courses.course_title',
                'courses.course_slug',
                'courses.course_image',
                'courses.course_price',
                'courses.course_discount',
                'course_formality_des',
                'courses.updated_at'
            )
                ->join('course_formality', 'course_formality.course_formality_id', '=', 'courses.course_formality_id')
                ->where('courses.course_slug', $course_slug)
                ->where('courses.course_status', 1)
                ->first();
        } else {
            $courses = Courses::select('courses.course_code',
                'courses.course_id',
                'courses.course_title',
                'courses.course_slug',
                'courses.course_image',
                'course_join_formality.course_formality_price as course_price',
                'course_join_formality.course_formality_discount as course_discount',
                'course_join_formality.course_formality_des as course_formality_des',
                'courses.updated_at'
            )
                ->join('course_join_formality', 'course_join_formality.course_id', '=', 'courses.course_id')
                ->where('courses.course_slug', $course_slug)
                ->where('course_join_formality.course_formality_id', $course_formality_id)
                ->where('courses.course_status', 1)
                ->first();
        }
        if (empty($courses->course_discount)) {
            return view('site.course_site.payment_course_free', compact('courses'));
        }
//        echo '<pre>';
//        print_r($courses);
        if (empty($courses)) {
            return view('site.course_site.error_course_404');
        }
        return view('site.course_site.payment_course', compact('courses'));
    }

    //thanh toan khóa và gửi email thông báo khóa học đang chờ xác nhận
    public function payment_course(Request $request)
    {
        $course_id = $request->input('course_id');
//        echo $course_id;die;
        $learn_id = $request->input('learn_id');
        $course_min_price = Learn_training::where('courses_id', $course_id)
            ->where('learn_id', $learn_id)
            ->first();
        //check trang thai thanh toán cua khóa học miễn phí = 1 luôn
        $course_order_status = 0;
        if (empty($course_min_price->learn_discount) || empty($course_min_price->learn_price)) {
            $course_order_status = 1;
        }
        $courses = Courses::select('*')
            ->where('courses.course_id', $course_id)
            ->first();
        if (empty($courses)) {
            return view('site.course_site.error_course_404');
        }
        $course_cost = !empty($courses->course_discount) ? $courses->course_discount : $course_min_price->course_price;
        if (!empty($course_min_price)) {
            $course_cost = !empty($course_min_price->learn_discount) ? $course_min_price->learn_discount : $course_min_price->learn_price;
        }
//        echo '<pre>';
//        print_r($course_cost);die;
        $couse_order_id = Course_order::insertGetId([
            'user_id' => !empty(Auth::user()->id) ? Auth::user()->id : 0,
            'course_id' => $request->input('course_id'),
            'employee_id' => !empty($request->input('employee_id')) ? $request->input('employee_id') : '',
            'course_formality_id' => !empty($request->input('course_formality_id')) ? $request->input('course_formality_id') : 0,
            'course_cost' => $course_cost,
            'course_order_status' => $course_order_status, //Trạng thái khóa học 0 là chưa thanh toán 1 là đã thanh toán và là miễn phí
            'activation_code_status' => 0,
            'course_name' => !empty($request->input('course_name')) ? $request->input('course_name') : '',
            'course_phone' => !empty($request->input('course_phone')) ? $request->input('course_phone') : '',
            'course_email' => !empty($request->input('course_email')) ? $request->input('course_email') : '',
            'course_messager' => !empty($request->input('course_messager')) ? $request->input('course_messager') : '',
            'learn_id' => !empty($course_min_price) ? $course_min_price->learn_id : 0,
            'learn_title' => !empty($course_min_price) ? $course_min_price->learn_title : '',
            'learn_price' => !empty($course_min_price) ? $course_min_price->learn_price : 0,
            'learn_discount' => !empty($course_min_price) ? $course_min_price->learn_discount : 0,
            'created_at' => new \DateTime()
        ]);
        $activation_code = Ultility::create_random_string(0, 5);
        $update_course_id = Course_order::where('course_order_id', $couse_order_id)->update([
            'activation_code' => $couse_order_id . $activation_code  //mã kích hoạt
        ]);
        $course_order = Course_order::where('course_order_id', $couse_order_id)->first();
//        $course = Courses::select('course_title',
//            'course_code',
//            'course_slug',
//            'course_image')
//            ->where('course_id', $course_order->course_id)
//            ->first();
        $course = Courses::select('courses.*',
            'course_code',
            'course_slug',
            'course_image')
            ->where('course_id', $course_order->course_id)
            ->first();
        if (empty($course_cost)) {
            $course_order = Course_order::where('course_order_id', $couse_order_id)->first();
            $course = Courses::select('course_title',
                'course_code',
                'course_slug',
                'course_image')
                ->where('course_id', $course_order->course_id)
                ->first();
            $send_email = MailConfigController::send_email_actove_course($course, $course_order);
            return redirect(route('noti_course_order', ['course_order_id' => $couse_order_id]))->with('success', 'Thanh toán đơn hàng thành công');
        }
        if($course_id == 39)
        {
            //don hang cho facebook có phí
            $send_email = MailConfigController::send_email_facebook_course($course, $course_order);
        }
        else
        {
            $send_email = MailConfigController::send_email_course($course, $course_order);
        }
        return redirect(route('noti_course_order', ['course_order_id' => $couse_order_id]))->with('success', 'Thanh toán đơn hàng thành công');

    }

    public function payment_course_free(Request $request)
    {
        if ($request->input('course_formality_id') == 1) {
            $courses = Courses::select('course_discount', 'course_price')
                ->where('course_id', $request->input('course_id'))
                ->first();
        } else {
            $courses = Courses::select('course_join_formality.course_formality_price as course_price',
                'course_join_formality.course_formality_discount as course_discount')
                ->join('course_join_formality', 'course_join_formality.course_id', '=', 'courses.course_id')
                ->where('courses.course_id', $request->input('course_id'))
                ->where('course_join_formality.course_formality_id', $request->input('course_formality_id'))
                ->first();
        }

        if (empty($courses)) {
            return view('site.course_site.error_course_404');
        }

        $couse_order_id = Course_order::insertGetId([
            'user_id' => !empty(Auth::user()->id) ? Auth::user()->id : 0,
            'course_id' => $request->input('course_id'),
            'employee_id' => !empty($request->input('employee_id')) ? $request->input('employee_id') : '',
            'course_formality_id' => $request->input('course_formality_id'),
            'course_cost' => !empty($courses->course_discount) ? $courses->course_discount : $courses->course_price,  //giá của khóa học
            'course_order_status' => 1, //vi là khóa học miễn phí nên thanh toán đơn hàng luôn
            'activation_code_status' => ($request->input('course_formality_id') == 1) ? 0 : 1, //trạng thái mã kích hoạt 0 là chưa 1 là đã sử dụng và nếu != thì là khác trạng thái tự học nên k có mã giảm kích hoạt
            'course_name' => $request->input('course_name'),
            'course_phone' => $request->input('course_phone'),
            'course_email' => $request->input('course_email'),
            'course_messager' => $request->input('course_messager'),
            'created_at' => new \DateTime()
        ]);
        if ($request->input('course_formality_id') == 1) {
            $activation_code = Ultility::create_random_string(0, 5);
            $update_course_id = Course_order::where('course_order_id', $couse_order_id)->update([
                'activation_code' => $couse_order_id . $activation_code  //mã kích hoạt
            ]);
        }
        $course_order = Course_order::where('course_order_id', $couse_order_id)->first();
        $course = Courses::select('course_title',
            'course_code',
            'course_slug',
            'course_image')
            ->where('course_id', $course_order->course_id)
            ->first();
        $send_email = MailConfigController::send_email_actove_course($course, $course_order);
        return redirect(route('noti_course_order_free', ['course_order_id' => $couse_order_id]))->with('success', 'Thanh toán đơn hàng thành công');

    }

    public function noti_course_order($course_order_id)
    {
        $course_order = Course_order::select('course_id',
            'course_order_id',
            'course_cost',  //giá của khóa học
            'course_order_status', //trạng thái thanh toán của kháo hoc 0 là chưa 1 đã thanh toán
            'admin_id',
            'admin_messager',
            'course_name',
            'course_phone',
            'course_email',
            'course_messager',
            'learn_id', //id cách học learn_training
            'learn_title',
            'learn_price',
            'learn_discount',
            'created_at')
            ->where('course_order_id', $course_order_id)
            ->first();


        $courses = Courses::select('course_code',
            'course_id',
            'course_title',
            'course_slug',
            'course_image',
            'course_price',
            'course_discount',
            'updated_at'
        )
            ->where('course_id', $course_order->course_id)
            ->where('course_status', 1)
            ->first();
        $learn_id = $course_order->learn_id;
        $course_min_price = Learn_training::where('courses_id', $course_order->course_id)
            ->where('learn_id', $learn_id)
            ->first();
        //check trang thai thanh toán cua khóa học miễn phí = 1 luôn
        if (empty($course_min_price->learn_discount) || empty($course_min_price->learn_price)) {
            return view('site.course_site.noti_course_order_free', compact('courses', 'course_order'));
        }
        return view('site.course_site.noti_course_order', compact('courses', 'course_order'));

    }

    public function noti_course_order_free($course_order_id)
    {
        $course_order = Course_order::select('course_id',
            'course_order_id',
            'course_cost',  //giá của khóa học
            'course_order_status', //trạng thái thanh toán của kháo hoc 0 là chưa 1 đã thanh toán
            'admin_id',
            'admin_messager',
            'course_name',
            'course_phone',
            'course_email',
            'course_messager',
            'created_at')
            ->where('course_order_id', $course_order_id)
            ->first();


        $courses = Courses::select('course_code',
            'course_id',
            'course_title',
            'course_slug',
            'course_image',
            'course_price',
            'course_discount',
            'updated_at'
        )
            ->where('course_id', $course_order->course_id)
            ->where('course_status', 1)
            ->first();
        return view('site.course_site.noti_course_order_free', compact('courses', 'course_order'));
    }

    public function CheckCourseChapterIsLearned($course_id, $course_chapter_id, $course_content_id, $employee_id)
    {
        $courseEmployeeStatusModel = new Course_employee_status();
        $course_status = $courseEmployeeStatusModel->where('course_id', $course_id)
            ->where('course_chapter_id', $course_chapter_id)
            ->where('course_content_id', $course_content_id)
            ->where('employee_id', $employee_id)
            ->first();
        if (empty($course_status)) {
            $course_learned = new Course_employee_status;
            $course_learned->course_id = $course_id;
            $course_learned->course_chapter_id = $course_chapter_id;
            $course_learned->course_content_id = $course_content_id;
            $course_learned->employee_id = $employee_id;
            $course_learned->created_at = new \DateTime();
            $course_learned->updated_at = new \DateTime();

            $course_learned->save();
            return false;
        } else {
            $course_status->updated_at = new \DateTime();
            $course_status->save();
            return true;
        }
    }

    function isEmployeeOwnCourse($course_id, $employee_id)
    {
        $courseEmployeeModel = new Course_employee();
        $courses = $courseEmployeeModel
            ->where('employee_id', $employee_id)
            ->where('course_id', $course_id)
            ->count();
        return $courses;
    }

    public function learingCourse($course_slug, $chapter_id, $content_id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('home')->with('mesage_modal', 'bạn cần đăng nhập để xem khóa học');
            }

            $course = Courses::where('course_slug', $course_slug)
                ->select('course_id',
                    'course_title',
                    'course_slug',
                    'teacher_id',
                    'course_price',
                    'course_discount'
                )
                ->first();

            if (empty($course)) {
                return redirect()->route('home')->with('mesage_modal', 'khóa học không tồn tại');
            }

            //check giao vien
            if (Auth::user()->role == 3) {
                $teacher = Teacher::where('user_id', Auth::id())
                    ->select('teacher_id',
                        'teacher_name',
                        'teacher_phone',
                        'teacher_email',
                        'teacher_images'
                    )
                    ->first();
                if ($teacher['teacher_id'] != $course['teacher_id']) {
                    return redirect()->route('home')->with('mesage_modal', 'bạn không sở hữu khóa học này');
                }
            } elseif (Auth::user()->role == 1) {
                $employee = Employee::where('user_id', Auth::id())
                    ->select('employee_id',
                        'employee_name',
                        'employee_image')
                    ->first();
                if (!empty($course['course_discount']) || !empty($course['course_price'])) {
                    if (empty($this->isEmployeeOwnCourse($course['course_id'], $employee['employee_id']))) {
                        return redirect()->route('home')->with('mesage_modal', 'bạn không sở hữu khóa học này');
                    }
                }
            } else {
                return redirect()->route('home')->with('mesage_modal', 'bạn không có quyền xem khóa học này');
            }
            // get data
            $course_content = Course_chapter_contents::select(
                'course_content_id',
                'course_id',
                'course_chapter_id',
                'course_content_title',
                'course_content_descript',
                'course_content_content',
                'course_link_youtuber'
            )
                ->where('course_content_id', $content_id)
                ->first();
            $islearn = $this->CheckCourseChapterIsLearned($course_content['course_id'], $chapter_id, $content_id, $employee['employee_id']);
            $course_content['isLearned'] = $islearn;


            $course_voucher = Course_content_voucher::select(
                'course_content_voucher_id',
                'content_voucher_title',
                'content_voucher_link'
            )
                ->where('course_content_id', $content_id)
                ->get();
            $course_voucher_answer = Course_content_voucher_answer::select(
                'course_content_voucher_answer_id',
                'content_voucher_title',
                'content_voucher_answer_link'
            )
                ->where('course_content_id', $content_id)
                ->get();

            $feedback = Course_feedback::where('course_id', $course['course_id'])
                ->where('employee_id', $employee['employee_id'])
                ->first();
            if (!empty($feedback)) {
                $course['feedback'] = true;
            }
            $list_question_content = Questions_course_chapter_contents::where('course_content_id', $course_content->course_content_id)
                ->get();
            $result_question = Result_question_course::where('course_content_id', $content_id)
                ->where('user_id', Auth::user()->id)
                ->first();
            $result_question_course = new Result_question_course();
            $result_id = $result_question_course->where('user_id', Auth::user()->id)
                ->where('course_content_id', $content_id)
                ->value('result_id');

            return view('site.course_site.learning_course', compact('course_content', 'course', 'course_voucher', 'course_voucher_answer', 'employee', 'list_question_content', 'course_slug', 'chapter_id', 'content_id', 'result_question'));
        } catch (\Exception $e) {
            return view('site.course_site.error_course_404');
        }
    }

    public function result_question_course(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('mesage_modal', 'bạn cần đăng nhập để xem khóa học');
        }
        $course_slug = $request->input('course_slug');
        $chapter_id = $request->input('chapter_id');
        $content_id = $request->input('content_id');

        $result_question_course = new Result_question_course();
        $result_id = $result_question_course->insertGetId([
            'user_id' => Auth::user()->id,
            'course_content_id' => $content_id,
            'created_at' => new \DateTime()
        ]);
        $detal_result_question_course = new Detail_result_question_course();
        $correct_answer = $request->input('answer');
        $total_ques = 0;
        foreach ($correct_answer as $id_ques => $correct) {
            $detal_result = $detal_result_question_course->insertGetId([
                'result_id' => $result_id,
                'id_ques' => $id_ques,
                'user_correct_ques' => $correct,
                'created_at' => new \DateTime()
            ]);
            $question = Questions_course_chapter_contents::where('id_ques', $id_ques)->first();
            if (!empty($question)) {
                if ($question->correct_answer == $correct) {
                    $total_ques = $total_ques + 1;
                }
            }
        }
        $update = $result_question_course->where('result_id', $result_id)->update([
            'total_ques' => $total_ques
        ]);
        return redirect(route('course_learingCourse', ['course_slug' => $course_slug, 'chapter_id' => $chapter_id, 'content_id' => $content_id]))->with('success_question', 'Nộp bài thành công');
    }

    public function result_question_course_question(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('mesage_modal', 'bạn cần đăng nhập để xem khóa học');
        }
        $course_slug = $request->input('course_slug');
        $chapter_id = $request->input('chapter_id');
        $content_id = $request->input('content_id');
        $id_ques = $request->input('id_ques');
        $result_question_course = new Result_question_course();
        $result_id = $result_question_course->where('user_id', Auth::user()->id)
            ->where('course_content_id', $content_id)
            ->value('result_id');
        if (empty($result_id)) {
            $result_id = $result_question_course->insertGetId([
                'user_id' => Auth::user()->id,
                'course_content_id' => $content_id,
                'created_at' => new \DateTime()
            ]);
        }
        $detal_result_question_course = new Detail_result_question_course();
        $correct_answer = $request->input('answer');

        $detal_result_id = $detal_result_question_course->where('result_id', $result_id)
            ->where('id_ques', $id_ques)
            ->value('detal_result_id');
//        echo $detal_result_id;die;
        if (empty($detal_result_id)) {
            $detal_result_insert = $detal_result_question_course->insertGetId([
                'result_id' => $result_id,
                'id_ques' => $id_ques,
                'user_correct_ques' => $correct_answer,
                'created_at' => new \DateTime()
            ]);
        } else {
            $detal_result_update = $detal_result_question_course->where('detal_result_id', $detal_result_id)
                ->update([
                    'user_correct_ques' => $correct_answer,
                    'updated_at' => new \DateTime()
                ]);
        }
        return redirect(route('course_learingCourse', ['course_slug' => $course_slug, 'chapter_id' => $chapter_id, 'content_id' => $content_id]))->with('success_question_modal', 'Nộp bài thành công');
    }

    public function ajax_add_question(Request $request)
    {
        $comment_content = $request->comment_content;
        $parent_comment_id = $request->parent_comment_id;
        $user_id = Auth::id();
        $course_id = $request->course_id;

        $courseQuestion = new Course_questions();

        $courseQuestion->course_id = $course_id;
        $courseQuestion->parent_course_comments_id = $parent_comment_id;
        $courseQuestion->user_id = $user_id;
        $courseQuestion->course_comments_content = $comment_content;
        $courseQuestion->created_at = new \DateTime();
        $courseQuestion->updated_at = new \DateTime();
        $courseQuestion->save();

        return response()->json([
            'question_id' => $courseQuestion->course_comments_id,
        ]);


    }

    public function ajax_add_feedback(Request $request)
    {

        $feedback_content = $request->feedback_content;
        $rating = $request->rating;
        $course_id = $request->course_id;
        $employee_id = $request->employee_id;

        if (strlen($feedback_content) < 100) {
            return response()->json([
                'status' => 400,
                'data' => 'feedback must longer than 100 characters',
            ]);
        }

        if ($rating < 1 || $rating > 5) {
            return response()->json([
                'status' => 400,
                'data' => 'wrong rating point',
            ]);
        }

        $feedback = Course_feedback::where('course_id', $course_id)
            ->where('employee_id', $employee_id)
            ->first();
        if (empty($feedback)) {
            $record = new Course_feedback();

            $record->course_id = $course_id;
            $record->employee_id = $employee_id;
            $record->course_feedback_descript = $feedback_content;
            $record->ratings = $rating;
            $record->created_at = new \DateTime();
            $record->updated_at = new \DateTime();
            $record->save();

            return response()->json([
                'status' => 200,
                'data' => 'add new feedback success',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'data' => 'record already exist!',
            ]);
        }


    }

    public function ajax_post_voucher_status(Request $request)
    {

        $course_id = $request->course_id;
        $course_content_id = $request->course_content_id;
        $course_content_voucher_id = $request->course_content_voucher_id;
        $course_chapter_id = $request->course_chapter_id;
        $employee_id = $request->employee_id;

        $voucher_status = new Course_status_voucher();

        $isExis = $voucher_status->where('course_content_voucher_id', $course_content_voucher_id)
            ->count();

        if ($isExis == 0) {
            $record = new Course_status_voucher();
            $record->course_id = $course_id;
            $record->course_content_id = $course_content_id;
            $record->course_content_voucher_id = $course_content_voucher_id;
            $record->course_chapter_id = $course_chapter_id;
            $record->employee_id = $employee_id;
            $record->created_at = new \DateTime();
            $record->updated_at = new \DateTime();
            $record->save();
        } else {
            return response([
                'status' => 'already exis',
            ]);
        }
        return response()->json([
            'status' => 200,
            'status_voucher_id' => $voucher_status->course_status_voucher_id,
        ]);


    }

    public function ajax_delete_voucher_status(Request $request)
    {
        $employee_id = $request->employee_id;
        $voucher_id = $request->course_content_voucher_id;

        Course_status_voucher::where('employee_id', '=', $employee_id)
            ->where('course_content_voucher_id', '=', $voucher_id)
            ->delete();

        return response()->json(['status' => '200']);
    }

    public function tryCourse($course_slug, $chapter_id, $content_id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->back()->with('mesage_modal', 'bạn cần đăng nhập để xem khóa học');
            }

            $course = Courses::where('course_slug', $course_slug)
                ->select('course_id',
                    'course_slug',
                    'teacher_id',
                    'course_price',
                    'course_discount'
                )
                ->first();

            if (empty($course)) {
                return redirect()->back()->with('mesage_modal', 'khóa học không tồn tại');
            }


            $employee = Employee::where('user_id', Auth::id())
                ->select('employee_id',
                    'employee_name',
                    'employee_image')
                ->first();
            // get data
            $course_content = Course_chapter_contents::select(
                'course_chapter_contents.course_content_id',
                'course_chapter_contents.course_id',
                'course_chapter_contents.course_chapter_id',
                'course_chapter_contents.course_content_title',
                'course_chapter_contents.course_content_descript',
                'course_chapter_contents.course_content_content',
                'course_chapter_contents.course_link_youtuber'
            )
                ->join('course_chapters', 'course_chapters.course_chapter_id', 'course_chapter_contents.course_chapter_id')
                ->where('course_chapter_contents.course_content_id', $content_id)
                ->where('course_chapters.course_chapter_status', 0)
                ->first();
            if (empty($course_content)) {
                return redirect()->back()->with('mesage_modal', 'bài học này không được học thử');
            }

            $course_voucher = Course_content_voucher::select(
                'course_content_voucher_id',
                'content_voucher_title',
                'content_voucher_link'
            )
                ->where('course_content_id', $content_id)
                ->get();
            $course_voucher_answer = Course_content_voucher_answer::select(
                'course_content_voucher_answer_id',
                'content_voucher_title',
                'content_voucher_answer_link'
            )
                ->where('course_content_id', $content_id)
                ->get();

            return view('site.course_site.try_course', compact('course_content', 'course', 'course_voucher', 'course_voucher_answer', 'employee'));
        } catch (\Exception $e) {
            return view('site.course_site.error_course_404');
        }
    }

    public function becomeTeacher()
    {
        $teacher = new Teacher();
        $list_teacher = $teacher->select('teacher.province', 'teacher.district', 'teacher.business_type_id', 'teacher.teacher_name', 'teacher.teacher_id', 'teacher.teacher_images', 'teacher.slug')
            ->join('courses', 'courses.teacher_id', 'teacher.teacher_id')
            ->orderBy('teacher.teacher_id', 'desc')
            ->limit(12)
            ->get();

        return view('site.course_site.become_teacher', compact('list_teacher'));
    }


    public function get_ajax_formality_id(Request $request)
    {
        $course_id = $request->input('course_id');
        $course_formality_id = $request->input('course_formality_id');
        if ($course_formality_id == 1) {
            $course_price = Courses::where('course_id', $course_id)
                ->select(
                    'courses.course_price',
                    'courses.course_discount',
                    'courses.updated_at',
                    'course_formality.course_formality_des'
                )
                ->join('course_formality', 'course_formality.course_formality_id', '=', 'courses.course_formality_id')
                ->where('course_id', $course_id)
                ->first();

        } else {
            $course_price = Course_join_formality::select('course_formality_price as course_price',
                'course_formality_discount as course_discount',
                'course_formality_des')
                ->where('course_id', $course_id)
                ->where('course_formality_id', $course_formality_id)
                ->first();
        }
        return response([
            'status' => 200,
            'course_price' => $course_price
        ])->header('Content-Type', 'text/plain');
    }

    public function sumbit_cart_course(Request $request)
    {
        $course_id = $request->input('course_id');
        $course_formality_id = $request->input('course_formality_id');
        $course_slug = Courses::where('course_id', $course_id)->value('course_slug');
        $learn_training = Learn_training::where('courses_id', $course_id)->count();
        if (!empty($learn_training)) {
            return redirect(route('resgiter_content_course', ['course_slug' => $course_slug]) . '?course_formality_id=' . $course_formality_id);
        }
        if (!empty($request->input('employee_id'))) {
            return redirect(route('course_payment', ['course_slug' => $course_slug]) . '?course_formality_id=' . $course_formality_id . '&employee_id=' . $request->input('employee_id'));
        }
        return redirect(route('course_payment', ['course_slug' => $course_slug]) . '?course_formality_id=' . $course_formality_id);
    }

    public function resgiter_content_course($course_slug)
    {
        $course = Courses::where('course_slug', $course_slug)->first();
        if($course->course_id == 39)
        {
            $list_trai = Training::where('course_id','!=',0)->get();
            $learn_training = Learn_training::where('courses_id', $course->course_id)->get();
            $trai_fr = Training::where('course_id',$course->course_id)->first();
            return view('site.course_site.resgiter_content_course2', compact('course', 'list_trai','trai_fr', 'learn_training'));
        }
        $list_trai = Training::where('course_id',0)->get();
        $learn_training = Learn_training::where('courses_id', $course->course_id)->get();
        $trai_fr = Training::where('course_id',$course->course_id)->first();
        return view('site.course_site.resgiter_content_course', compact('course', 'list_trai','trai_fr', 'learn_training'));

    }

    public function payment_learn(Request $request)
    {
        $course_id = $request->input('course_id');
        $learn_id = $request->input('learn_id');
        $courses = Courses::select('courses.course_code',
            'courses.course_id',
            'courses.course_title',
            'courses.course_slug',
            'courses.updated_at'
        )
            ->where('courses.course_id', $course_id)
            ->first();
        $course_min_price = Learn_training::where('courses_id', $course_id)
            ->where('learn_id', $learn_id)
            ->first();
        $list_training_1000 = \App\Entity\Learn_training_content::get_list_training($learn_id);
        if (empty($courses)) {
            return view('site.course_site.error_course_404');
        }
        if($course_id == 39)
        {
            $list_training_1000 = Training::where('course_id','!=',0)->get();
            return view('site.course_site.payment_course_learn2', compact('courses', 'course_min_price', 'list_training_1000'));
        }
        return view('site.course_site.payment_course_learn', compact('courses', 'course_min_price', 'list_training_1000'));
    }

    //khóa học
    public function teacher_create_courses(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }

        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('*')->get();
        return view('site.teacher_course_site.create_course', compact('user', 'list_category', 'list_tag'));
    }

    private function validateCourse($request)
    {
        $validation = Validator::make($request->all(), [
            'course_title' => 'required',
            'course_code' => 'required|unique:courses',
            'course_image' => 'required',
            'course_content' => 'required',
            'category_course_id' => 'required'
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'course_title.required' => 'Tiêu để không được để trống',
            'course_code.required' => 'Mã khóa học không được để trống',
            'course_code.unique' => 'Mã khóa học đã tồn tại',
            'course_image.required' => 'Hình ảnh không được bỏ trống',
            'category_course_id.required' => 'Vui lòng chọn danh mục'
        ]);
        return $validation;
    }

    public function teacher_store_courses(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $validation = $this->validateCourse($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký khóa học lỗi !')
                ->withInput();
        }
        $teacher_id = Teacher::where('user_id', $user->id)->value('teacher_id');
//        try {
        $courses_model = new Courses();
        $insert_id = $courses_model->insertGetId([
            'category_course_id' => $request->input('category_course_id'),
            'teacher_id' => $teacher_id,
            'course_title' => $request->input('course_title'),
            'course_code' => $request->input('course_code'),
            'course_image' => $request->input('course_image'),
            'course_descript' => $request->input('course_descript'),
            'course_content' => $request->input('course_content'),
            'course_benefit' => $request->input('course_benefit'), //Lợi ích khóa học
            'activation_code' => $request->input('activation_code'), // mã kích hoạt khóa học mặc định
            'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
            'course_discount' => !empty($request->input('course_discount')) ? str_replace(".", "", $request->input('course_discount')) : 0,
            'course_status' => 0,
            'created_at' => new \DateTime(),
        ]);
        $activation_code = Ultility::create_random_string(0, 6) . $insert_id;
        if (!empty($request->input('activation_code'))) {
            $activation_code = substr($request->activation_code . $insert_id, 0, 6);
        } else {
            $activation_code = substr($request->course_code . $insert_id, 0, 6);
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

        return redirect(route('list_teacher_courses'))->with('success', 'Thêm khóa học thành công');
    }

    public function teacher_edit_courses(Request $request, $courses_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $teacher_id = Teacher::where('user_id', $user->id)->value('teacher_id');
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('*')->get();
        $tags = Course_tag_id::select('*')->where('course_id', $courses_id)->get();
        $tag = array();
        foreach ($tags as $t) {
            $tag[] = $t->tag_id;
        }
        $course = new Courses();
        $course = $course->select('courses.*')
            ->where('courses.course_id', $courses_id)
            ->where('teacher_id', $teacher_id)
            ->first();
        return view('site.teacher_course_site.edit_course', compact('list_category', 'course', 'list_tag', 'tag'));
    }

    public function teacher_update_courses(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_id = $request->input('course_id');
        $courses_model = new Courses();
        $update = $courses_model->where('course_id', $course_id)->update([
            'category_course_id' => $request->input('category_course_id'),
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
            $activation_code = substr($request->activation_code . $course_id, 0, 6);
            $update_activation_code = $courses_model->where('course_id', $course_id)->update([
                'activation_code' => $activation_code
            ]);
        } else {
            $activation_code = substr($request->course_code . $course_id, 0, 6);
            $update_activation_code = $courses_model->where('course_id', $course_id)->update([
                'activation_code' => $activation_code
            ]);
        }
        if (!empty($request->input('tag_id'))) {
            Course_tag_id::where('course_id', $course_id)->delete();
            $list_tag = $request->input('tag_id');
            foreach ($list_tag as $tag_id) {
                Course_tag_id::insertGetId([
                    'tag_id' => $tag_id,
                    'course_id' => $course_id,
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        return redirect(route('list_teacher_courses'))->with('success', 'Cập nhật khóa học thành công');
    }

    public function teacher_delete_courses(Request $request, $courses_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        try {
            $courses_model = new Courses();
            $delete_id = $courses_model->where('course_id', $courses_id)->delete();
            return redirect(route('list_teacher_courses'))->with('success', 'Xóa khóa học thành công');
        } catch (\Exception $exception) {
            return redirect(route('list_teacher_courses'))->with('error', 'Xóa khóa học thất bại');
        }
    }
    // end khoa học

    //chương khóa học
    public function list_course_chapter(Request $request, $courses_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $teacher_id = Teacher::where('user_id', $user->id)->value('teacher_id');
        $course = new Courses();
        $course = $course->select('course_id',
            'course_title',
            'course_code')
            ->where('courses.course_id', $courses_id)
            ->where('teacher_id', $teacher_id)
            ->first();
        $course_chapters = new Course_chapters();
        $list_course_chapter = $course_chapters->select('*')->where('course_id', $courses_id)->get();
        $total_course_chapter = $course_chapters->where('course_id', $courses_id)->count();
        return view('site.teacher_course_site.list_chapter', compact('course', 'list_course_chapter', 'total_course_chapter'));
    }

    public function create_course_chapter(Request $request, $courses_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course = new Courses();
        $course = $course->select('course_id',
            'course_title',
            'course_code')
            ->where('courses.course_id', $courses_id)
            ->first();
        return view('site.teacher_course_site.create_chapter', compact('course'));
    }

    public function store_course_chapter(Request $request)
    {
        $course_chapter = new Course_chapters();
        $courses_id = $request->input('course_id');
        $insert = $course_chapter->insertGetId([
            'course_id' => $courses_id,
            'course_chapter_name' => $request->input('course_chapter_name'),
            'course_chapter_status' => $request->input('course_chapter_status'),
            'course_chapter_descript' => $request->input('course_chapter_descript'),
            'course_chapter_content' => $request->input('course_chapter_content'),
            'created_at' => new \DateTime(),
        ]);
        return redirect(route('list_course_chapter', ['courses_id' => $courses_id]))->with('success', 'Thêm chương thành công');


    }

    public function edit_course_chapter(Request $request, $chapter_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_model = new Course_chapters();
        $course_chapter = $course_chapter_model->where('course_chapter_id', $chapter_id)->first();
        return view('site.teacher_course_site.edit_chapter', compact('course_chapter'));
    }

    public function update_course_chapter(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_model = new Course_chapters();
        $course_chapter_id = $request->input('course_chapter_id');
        $update = $course_chapter_model->where('course_chapter_id', $course_chapter_id)
            ->update([
                'course_chapter_name' => $request->input('course_chapter_name'),
                'course_chapter_status' => $request->input('course_chapter_status'),
                'course_chapter_descript' => $request->input('course_chapter_descript'),
                'course_chapter_content' => $request->input('course_chapter_content'),
                'updated_at' => new \DateTime(),
            ]);
        $course_chapter = $course_chapter_model->where('course_chapter_id', $course_chapter_id)
            ->first();
        $courses_id = $course_chapter->course_id;
        return redirect(route('list_course_chapter', ['courses_id' => $courses_id]))->with('success', 'Cập nhật chương thành công');
    }

    public function delete_course_chapter(Request $request, $course_chapter_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_model = new Course_chapters();
        $course_chapter = $course_chapter_model->where('course_chapter_id', $course_chapter_id)
            ->first();
        $courses_id = $course_chapter->course_id;
        $course_chapter = $course_chapter_model->where('course_chapter_id', $course_chapter_id)
            ->delete();
        return redirect(route('list_course_chapter', ['courses_id' => $courses_id]))->with('success', 'Xóa chương thành công');
    }
//    end khóa học
//    chương nội dung bài học

    public function list_chapter_content(Request $request, $course_chapter_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id', 'course_chapter_name', 'course_chapter_id')->where('course_chapter_id', $course_chapter_id)->first();
        $course_chapter_content = new Course_chapter_contents();
        $list_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id', $course_chapter_id)->get();
        $total_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id', $course_chapter_id)->count();
        $course_title = Courses::where('course_id', $course_chapter->course_id)->value('course_title');

        return view('site.teacher_course_site.list_chapter_content', compact('course_chapter', 'list_chapter_content'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function create_chapter_content(Request $request, $course_chapter_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id', 'course_chapter_name', 'course_chapter_id')->where('course_chapter_id', $course_chapter_id)->first();
        $course_chapter_content = new Course_chapter_contents();
        $list_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id', $course_chapter_id)->get();
        $total_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id', $course_chapter_id)->count();
        $course_title = Courses::where('course_id', $course_chapter->course_id)->value('course_title');

        return view('site.teacher_course_site.create_chapter_content', compact('course_chapter', 'list_chapter_content'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function store_chapter_content(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_content = new Course_chapter_contents();
        $insert = $course_chapter_content->insertGetId([
            'course_id' => $request->input('course_id'),
            'course_chapter_id' => $request->input('course_chapter_id'),
            'course_content_title' => $request->input('course_content_title'),
            'course_content_image' => $request->input('course_content_image'),
            'course_content_descript' => $request->input('course_content_descript'),
            'course_content_content' => $request->input('course_content_content'),
            'course_link_youtuber' => $request->input('course_link_youtuber'),
            'created_at' => new \DateTime()
        ]);
        return redirect(route('list_chapter_content', ['course_chapter_id' => $request->input('course_chapter_id')]))->with('success', 'Thêm mới bài học thành công');
    }

    public function edit_chapter_content(Request $request, $course_content_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_content = new Course_chapter_contents();
        $chapter_content = $course_chapter_content->select('*')->where('course_content_id', $course_content_id)
            ->first();

        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id', 'course_chapter_name', 'course_chapter_id')->where('course_chapter_id', $chapter_content->course_chapter_id)->first();

        return view('site.teacher_course_site.edit_chapter_content', compact('chapter_content', 'course_chapter'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function update_chapter_content(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter = new Course_chapter_contents();
        $course_content_id = $request->input('course_content_id');

        $update = $course_chapter->where('course_content_id', $course_content_id)
            ->update([
                'course_content_title' => $request->input('course_content_title'),
                'course_content_image' => $request->input('course_content_image'),
                'course_content_descript' => $request->input('course_content_descript'),
                'course_content_content' => $request->input('course_content_content'),
                'course_link_youtuber' => $request->input('course_link_youtuber'),
                'updated_at' => new \DateTime()
            ]);
        $course_content = $course_chapter->where('course_content_id', $course_content_id)->first();
        $course_chapter_id = $course_content->course_chapter_id;
        return redirect(route('list_chapter_content', ['course_chapter_id' => $course_chapter_id]))->with('success', 'Cập nhật bài học thành công');

    }

    public function delete_chapter_content(Request $request, $course_content_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter = new Course_chapter_contents();
        $update = $course_chapter->where('course_content_id', $course_content_id)
            ->delete();
        return redirect()->back()->with('success', 'Xóa bài học thành công');
    }

    //danh sahcs cau hoi trac nghiem
    public function list_content_question($course_content_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $course = Courses::where('course_id', $course_content->course_id)->first();
        $course_chapter = Course_chapters::where('course_chapter_id', $course_content->course_chapter_id)->first();

        $list_question = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->get();
        $total_question = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->count();

//        echo '<pre>';
//        print_r($course_chapter);die;
//        return view('admin.course.course_question.list', compact('course_content', 'course', 'course_chapter', 'list_question', 'total_question'));

        return view('site.teacher_course_site.list_content_question', compact('course_content', 'course', 'course_chapter', 'list_question', 'total_question'));
    }

    public function select_content_question($course_content_id)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $course = Courses::where('course_id', $course_content->course_id)->first();
        $course_chapter = Course_chapters::where('course_chapter_id', $course_content->course_chapter_id)->first();

        $list_question = Questions_course_chapter_contents::where('user_id', $user->id)
//            ->where('course_content_id','!=',$course_content_id)
            ->paginate(30);
//        echo '<pre>';
//        print_r($course_content->course_content_id);die;
//        return view('admin.course.course_question.list', compact('course_content', 'course', 'course_chapter', 'list_question', 'total_question'));

        return view('site.teacher_course_site.select_content_question', compact('course_content', 'course', 'course_chapter', 'list_question'));
    }

    public function post_content_question(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_content_id = $request->input('course_content_id');
        $id_ques_aray = $request->input('id_ques');
        $contents = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $question = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->first();
        if (!empty($id_ques_aray)) {
            foreach ($id_ques_aray as $id_ques) {
                $check_question = Questions_course_chapter_contents::where('id_ques', $id_ques)->first();
                if (empty($check_question->course_content_id)) {
//                    echo $course_content_id;die;
//                    echo '<pre>';
//                    print_r($contents);die;
                    $update = Questions_course_chapter_contents::where('id_ques', $id_ques)->update([
                        'course_id' => !empty($contents->course_id) ? $contents->course_id : '',
                        'course_content_id' => !empty($contents->course_content_id) ? $contents->course_content_id : '',
                        'course_chapter_id' => !empty($contents->course_chapter_id) ? $contents->course_chapter_id : '',
                        'updated_at' => new \DateTime()
                    ]);
                } else {
                    $insert = Questions_course_chapter_contents::insert([
                        'user_id' => $user->id,
                        'course_id' => !empty($contents->course_id) ? $contents->course_id : '',
                        'course_content_id' => !empty($contents->course_content_id) ? $contents->course_content_id : '',
                        'course_chapter_id' => !empty($contents->course_chapter_id) ? $contents->course_chapter_id : '',
                        'name_ques' => !empty($question->name_ques) ? $question->name_ques : '',
                        'type_ques' => !empty($question->type_ques) ? $question->type_ques : 0,
                        'show_answer_ques' => !empty($question->show_answer_ques) ? $question->show_answer_ques : '',
                        'type_answer' => !empty($question->type_answer) ? $question->type_answer : 0,
                        'answer1' => !empty($question->answer1) ? $question->answer1 : '',
                        'answer2' => !empty($question->answer2) ? $question->answer2 : '',
                        'answer3' => !empty($question->answer3) ? $question->answer3 : '',
                        'answer4' => !empty($question->answer4) ? $question->answer4 : '',
                        'correct_answer' => !empty($question->correct_answer) ? $question->correct_answer : '',
                        'created_at' => new \DateTime()
                    ]);
                }

            }
        }
//        return redirect()->back()->with('success', 'Chọn câu hỏi cho bài học thành công');
//        route('list_content_question',['content_id' => $course_content->course_content_id])
        return redirect(route('list_content_question', ['content_id' => $course_content_id]))->with('success', 'Chọn câu hỏi cho bài học thành công');
    }

    public function create_content_question(Request $request, $course_content_id)
    {
        //trường hợp thêm mới từ giáo viên không chọn khóa học
        if (empty($course_content_id)) {
            return view('site.teacher_course_site.create_teacher_question');
        }
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
//        $course = Courses::where('course_id',$course_content->course_id)->first();
//        $course_chapter = Course_chapters::where('course_chapter_id',$course_content->course_chapter_id)->first();
        return view('site.teacher_course_site.create_content_question', compact('course_content'));
//        return view('admin.course.course_question.add', compact('course_content'));

    }

    public function store_content_question(Request $request)
    {
        $course_content_id = $request->input('course_content_id');
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $question = new Questions_course_chapter_contents();
        $question_idZero = $question->insertGetId([
            'user_id' => Auth::user()->id,
            'course_id' => !empty($course_content->course_id) ? $course_content->course_id : 0,
            'course_content_id' => !empty($course_content->course_content_id) ? $course_content->course_content_id : 0,
            'course_chapter_id' => !empty($course_content->course_chapter_id) ? $course_content->course_chapter_id : 0,
            'name_ques' => $request->input('name_ques'),
            'type_ques' => 0,
            'show_answer_ques' => $request->input('show_answer_ques'),
            'type_answer' => 0,
            'answer1' => $request->input('answer1'),
            'answer2' => $request->input('answer2'),
            'answer3' => $request->input('answer3'),
            'answer4' => $request->input('answer4'),
            'correct_answer' => $request->input('correct_answer'),
            'created_at' => new \DateTime()
        ]);
        if (empty($course_content_id)) {
            return redirect(route('list_teacher_exam'))->with('success', 'Thêm câu hỏi thành công');

        }
        return redirect(route('list_content_question', ['course_content_id' => $course_content_id]))->with('suscees', 'Thêm thành công');
    }

    public function edit_content_question(Request $request, $id_ques)
    {
        $question = Questions_course_chapter_contents::where('id_ques', $id_ques)->first();
        $course_content = Course_chapter_contents::where('course_content_id', $question->course_content_id)->first();
//        return view('admin.course.course_question.edit', compact('course_content', 'question'));

        return view('site.teacher_course_site.edit_content_question', compact('course_content', 'question'));
    }

    public function update_content_question(Request $request)
    {
//        echo 1;die;
        $id_ques = $request->input('id_ques');
        $question = new Questions_course_chapter_contents();
        $question_idZero = $question->where('id_ques', $id_ques)->update([
            'user_id' => Auth::user()->id,
            'name_ques' => $request->input('name_ques'),
            'type_ques' => 0,
            'show_answer_ques' => $request->input('show_answer_ques'),
            'type_answer' => 0,
            'answer1' => $request->input('answer1'),
            'answer2' => $request->input('answer2'),
            'answer3' => $request->input('answer3'),
            'answer4' => $request->input('answer4'),
            'correct_answer' => $request->input('correct_answer'),
            'updated_at' => new \DateTime()
        ]);
        $course_content_id = $question->where('id_ques', $id_ques)->value('course_content_id');
        if (empty($course_content_id)) {
            return redirect(route('list_teacher_exam'))->with('success', 'Chỉnh sửa câu hỏi thành công');

        }
        return redirect(route('list_content_question', ['course_content_id' => $course_content_id]))->with('suscees', 'Cập nhật thành công');
    }

    public function delete_content_question(Request $request, $id_ques)
    {
        $question = new Questions_course_chapter_contents();
        $course_content_id = $question->where('id_ques', $id_ques)->value('course_content_id');
        $question_idZero = $question->where('id_ques', $id_ques)->delete();
        if (empty($course_content_id)) {
            return redirect(route('list_teacher_exam'))->with('success', 'Xóa câu hỏi thành công');

        }
        return redirect(route('list_content_question', ['course_content_id' => $course_content_id]))->with('suscees', 'Xóa thành công');

    }
    //end cau hoi trac nghiem
//Route::get('giao-vien/bai-hoc/danh-sach-cau-hoi/{content_id}','Course\CoursesController@list_content_question')->name('list_content_question');
//Route::get('giao-vien/bai-hoc/them-moi-cau-hoi/{content_id}','Course\CoursesController@create_content_question')->name('create_content_question');
//Route::get('giao-vien/bai-hoc/chinh-sua-cau-hoi/{ques_id}','Course\CoursesController@edit_content_question')->name('edit_content_question');
//Route::post('giao-vien/bai-hoc/store-cau-hoi','Course\CoursesController@store_content_question')->name('store_content_question');
//Route::post('giao-vien/bai-hoc/update-cau-hoi','Course\CoursesController@update_content_question')->name('update_content_question');
//Route::post('giao-vien/bai-hoc/delete-cau-hoi/{ques_id}','Course\CoursesController@delete_content_question')->name('delete_content_question');

    public function list_teacher_exam(Request $request)
    {
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $list_question = Questions_course_chapter_contents::where('user_id', $user->id)->get();
        $total_question = Questions_course_chapter_contents::where('user_id', $user->id)->count();

//        echo '<pre>';
//        print_r($course_chapter);die;
//        return view('admin.course.course_question.list', compact('course_content', 'course', 'course_chapter', 'list_question', 'total_question'));

        return view('site.teacher_course_site.list_teacher_exam', compact('list_question', 'total_question'));
    }
//Route::get('giao-vien/danh-sach-tai-lieu/{content_id}','Course\CoursesController@list_voucher_content')->name('list_voucher_content');
//Route::get('giao-vien/them-tai-lieu/{content_id}','Course\CoursesController@create_voucher_content')->name('create_voucher_content');
//Route::post('giao-vien/bai-hoc/luu-tai-lieu','Course\CoursesController@store_voucher_content')->name('store_voucher_content');
//Route::get('giao-vien/cap-nhat-tai-lieu/{content_id}','Course\CoursesController@edit_voucher_content')->name('edit_voucher_content');
//Route::post('giao-vien/course_content_update_voucher','Course\CoursesController@update_voucher_content')->name('update_voucher_content');
//Route::post('giao-vien/course_content_delete_voucher/{content_id}','Course\CoursesController@delete_voucher_content')->name('delete_voucher_content');

    //danh sách tài liệu của khóa học
    public function list_voucher_content(Request $request, $course_content_id)
    {
//        echo $course_content_id;die;
        $user = Auth::user();
        if (empty($user) || $user->role != 3) {
            return redirect(route('home'));
        }
        $course_chapter_contents_model = new Course_chapter_contents();
        $course_chapter_contents = $course_chapter_contents_model->select('*')->where('course_content_id', $course_content_id)->first();


        $course_voucher = new Course_content_voucher();
        $list_voucher = $course_voucher->select('*')->where('course_content_id', $course_content_id)->get();
        $total_voucher = $course_voucher->where('course_content_id', $course_content_id)->count();

        $course_voucher_answer = new Course_content_voucher_answer();
        $list_voucher_answer = $course_voucher_answer->select('*')->where('course_content_id', $course_content_id)->get();
        $total_voucher_answer = $course_voucher_answer->where('course_content_id', $course_content_id)->count();

        $course_chapter = new Course_chapter_contents();
        $course_chapter = $course_chapter->where('course_content_id', $course_content_id)
            ->first();


        return view('site.teacher_course_site.list_voucher_content', compact('course_chapter_contents', 'list_voucher', 'list_voucher_answer', 'course_chapter'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function store_content_voucher(Request $request)
    {
        DB::beginTransaction();
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_id = $course_voucher->insertGetId([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'course_content_id' => $request->input('course_content_id'),
            'created_at' => new \DateTime()
        ]);
        $content_voucher_link = $this->upload_file($request, 'content_voucher_link', $course_content_voucher_id, Auth::user()->id);
        if (empty($content_voucher_link)) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher = $course_voucher->where('course_content_voucher_id', $course_content_voucher_id)
            ->update([
                'content_voucher_link' => $content_voucher_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Thêm mới tài liệu thành công');
    }

    public function update_content_voucher(Request $request)
    {

        DB::beginTransaction();
        $course_content_voucher_id = $request->input('course_content_voucher_id');
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_id', $course_content_voucher_id)->update([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'updated_at' => new \DateTime()
        ]);
        $course_content_voucher = $course_voucher->select('content_voucher_link')->where('course_content_voucher_id', $course_content_voucher_id)->first();
        $content_voucher_link = $course_content_voucher->content_voucher_link;
        if (!empty($request->input('check_content_voucher_link'))) {
            $content_voucher_link = $this->upload_file($request, 'content_voucher_link', $course_content_voucher_id, Auth::user()->id);
        }
        if (empty($content_voucher_link)) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher = $course_voucher->where('course_content_voucher_id', $course_content_voucher_id)
            ->update([
                'content_voucher_link' => $content_voucher_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật tài liệu thành công');

    }

    public function delete_content_voucher(Request $request, $course_content_voucher_id)
    {
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_id', $course_content_voucher_id)->delete();
        return redirect()->back()->with('success', 'Xóa tài liệu thành công');
    }

    public function store_content_voucher_answer(Request $request)
    {
        DB::beginTransaction();
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_id = $course_voucher->insertGetId([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'course_content_id' => $request->input('course_content_id'),
            'created_at' => new \DateTime()
        ]);
        $content_voucher_answer_link = $this->upload_file($request, 'content_voucher_answer_link', $course_content_voucher_id, Auth::user()->id);
        if (empty($content_voucher_answer_link)) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher = $course_voucher->where('course_content_voucher_answer_id', $course_content_voucher_id)
            ->update([
                'content_voucher_answer_link' => $content_voucher_answer_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Thêm mới tài liệu đáp án thành công');
    }

    public function update_content_voucher_answer(Request $request)
    {

        DB::beginTransaction();
        $course_content_voucher_id = $request->input('course_content_voucher_answer_id');
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_answer_id', $course_content_voucher_id)->update([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'updated_at' => new \DateTime()
        ]);
        $course_content_voucher = $course_voucher->select('content_voucher_answer_link')->where('course_content_voucher_answer_id', $course_content_voucher_id)->first();
        $content_voucher_answer_link = $course_content_voucher->content_voucher_answer_link;
        if (!empty($request->input('check_content_voucher_answer_link'))) {
            $content_voucher_answer_link = $this->upload_file($request, 'content_voucher_answer_link', $course_content_voucher_id, Auth::user()->id);
        }
        if (empty($content_voucher_answer_link)) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher = $course_voucher->where('course_content_voucher_answer_id', $course_content_voucher_id)
            ->update([
                'content_voucher_answer_link' => $content_voucher_answer_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật tài liệu đáp án thành công');

    }

    public function delete_content_voucher_answer(Request $request, $course_content_voucher_answer_id)
    {
//        echo $course_content_voucher_answer_id;die;
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_delete = $course_voucher->where('course_content_voucher_answer_id', $course_content_voucher_answer_id)->delete();
        return redirect()->back()->with('success', 'Xóa tài liệu đáp án thành công');

    }

    public function upload_file(Request $request, $input_name, $id, $user_id)
    {
        $link_image = '';
        $path_forder_images = public_path('/upload_file_course/' . $user_id);

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType = $file->getClientOriginalExtension();
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
//            $allowtypes = array('doc', 'docx', 'xlsx', 'xls','pdf','pptx');
//            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
//                return 0;
//            }
            if ($file->getSize() >= $maxsize) {
                return 0;
            }
            $name_file = $user_id . '_' . $id . '_' . $file->getClientOriginalName();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/upload_file_course/' . $user_id . '/' . $name_file;
            return $link_image;
        }
        return 0;
    }


}
