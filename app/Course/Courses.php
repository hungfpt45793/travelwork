<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Courses extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course_id',
        'category_course_id',
        'teacher_id',
        'course_title',
        'course_code',
        'course_slug',
        'course_image',
        'course_descript',
        'course_content',
        'course_benefit', //Lợi ích khóa học
        'activation_code', // mã kích hoạt khóa học mặc định
        'course_price',
        'course_discount',
        'course_views',
        'course_study',
        'admin_id', //user duyệt khóa học
        'course_status', //0 là admin chưa duyệt , 1 là admin duyệt
        'course_formality_id', // = 1 trạng thái tự học
        'title_detail1',  //⦁	Đăng ký học ngay -> Đăng ký tham gia nhóm
        'title_detail2', //⦁	 Sở hữu khóa học trọn đời -> Phí thành viên đóng linh hoạt
        'title_detail3', //⦁	 Khoá học này dành cho -> Nhóm Facebook này dành cho
        'title_detail4', //⦁	 Bạn sẽ nhận được gì nếu đăng ký khóa học này -> Bạn sẽ nhận được gì nếu tham gia nhóm Facebook này
        'title_detail5', //⦁	 Nội dung khoá học -> Những nội dung được hỗ trợ trả lời trong nhóm
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function get_couse_slug($course_id)
    {
        $course_slug = Courses::where('course_id', $course_id)->value('course_slug');
        return $course_slug;
    }

    public static function get_teacher_id($course_id)
    {
        $teacher_id = Courses::where('course_id', $course_id)->value('teacher_id');
        return $teacher_id;
    }

    static function getCourse_slug($course_slug)
    {
        $course = Courses::where('course_slug', $course_slug)
            ->select(
                'courses.course_id',
                'courses.course_title',
                'courses.course_code',
                'courses.course_benefit',
                'courses.course_slug',
                'courses.course_image',
                'courses.course_descript',
                'courses.course_content',
                'courses.course_price',
                'courses.course_discount',
                'courses.updated_at',
                'courses.course_formality_id',
                'teacher.teacher_name',
                'teacher.slug',
                'teacher.teacher_images',
                'course_formality.course_formality_title',
                'course_formality.course_formality_des'
            )
            ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
            ->join('course_formality', 'courses.course_formality_id', '=', 'course_formality.course_formality_id')
            ->where('course_status', 1)
            ->first();

        return $course;
    }

    static function getTotallChapterContent($course_id)
    {
        $course = new Courses();
        return $course->join('course_chapter_contents', 'course_chapter_contents.course_id', '=', 'courses.course_id')
            ->where('courses.course_id', $course_id)
            ->count();
    }

    static function getCourse_category_slug($category_course_slug, $count = 8, $order = 'desc')
    {

        $courseModel = new Courses();
        $courseEmployeeModel = new Course_employee();
        $courseFeedbackModel = new Course_feedback();

        if ($category_course_slug == 'tat-ca-khoa-hoc') {
            $courses = $courseModel
                ->select(
                    'courses.course_id',
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
                ->orderBy('courses.course_id', $order)
                ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                ->where('courses.course_status', 1)
                ->limit($count)
                ->get();
        } else {

            $category_course_id = Category_course::where('category_course_slug', $category_course_slug)
                ->first();

            if (!isset($category_course_id))
                return [];
            else
                $category_course_id = $category_course_id['category_course_id'];

            $courses = $courseModel
                ->select(
                    'courses.course_id',
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
                ->where('category_course_id', $category_course_id)
                ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                ->where('courses.course_status', 1)
                ->limit($count)
                ->orderBy('courses.course_id', $order)
                ->get();
        }


        foreach ($courses as $id => $course) {
            $count = $courseEmployeeModel->where('course_id', $course->course_id)
                ->count();
            $rating = $courseFeedbackModel::getRatings($course['course_slug']);
            if (!$rating) {
                $rating['star'] = 5;
                $rating['total_feedback'] = 0;
            }
            $courses[$id]['total_employee'] = $count;
            $courses[$id]['star'] = $rating['star'];
            $courses[$id]['total_feedback'] = $rating['total_feedback'];
        }

        return $courses;
    }

    public static function get_courses($count)
    {
        $courseEmployeeModel = new Course_employee();
        $courseFeedbackModel = new Course_feedback();
        $list_course = Courses::select('course_title',
            'course_code',
            'course_id',
            'course_slug',
            'course_image',
            'course_views',
            'course_price',
            'course_discount')
            ->where('course_status', 1)
            ->orderBy('course_id', 'desc')
            ->limit($count)
            ->get();

        foreach ($list_course as $id => $course) {
            $count = $courseEmployeeModel->where('course_id', $course->course_id)
                ->count();
            $rating = $courseFeedbackModel::getRatings($course['course_slug']);
            if (!$rating) {
                $rating['star'] = 5;
                $rating['total_feedback'] = 0;
            }
            $list_course[$id]['total_employee'] = $count;
            $list_course[$id]['star'] = $rating['star'];
            $list_course[$id]['total_feedback'] = $rating['total_feedback'];
        }
        return $list_course;
    }


}
