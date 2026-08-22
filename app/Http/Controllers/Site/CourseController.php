<?php

namespace App\Http\Controllers\Site\Course;

use App\Course\Category_course;
use App\Course\Course_employee;
use App\Course\Course_feedback;
use App\Course\Courses;
use App\Http\Controllers\Site\SiteController;
use App\Entity\Teacher;

class CourseController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'teacher');
    }

    public function index()
    {

        $teacher = new Teacher();
        $list_teacher = $teacher->select('province', 'district', 'business_type_id', 'teacher_name', 'teacher_id', 'teacher_images', 'slug');
        $list_teacher = $list_teacher->orderBy('teacher.teacher_id', 'desc')->limit(8)->get();


        $cate_course = new Category_course();
        $course_categorise = $cate_course->select(
            'category_course_id',
            'category_course_title',
            'category_course_slug',
            'category_course_desc'
        )
            ->where('deleted_at', null)
            ->limit(12)
            ->get();


        $cate_ids = [];
        $cate_slugs = [];
        $list_course = [];

        $courseModel = new Courses();
        $course_employeeModel = new Course_employee();
        foreach ($course_categorise as $course_cate) {
            array_push($cate_ids, $course_cate->category_course_id);
            array_push($cate_slugs, $course_cate->category_course_title);
            $courses = $courseModel
                ->select(
                    'courses.course_id',
                    'courses.course_title',
                    'courses.course_slug',
                    'courses.course_image',
                    'courses.course_descript',
                    'courses.course_content',
                    'courses.course_price',
                    'courses.course_discount',
                    'teacher.teacher_name',
                    'teacher.slug',
                    'teacher.teacher_images'
                )
                ->where('category_course_id', $course_cate->category_course_id)
                ->where('courses.deleted_at', null)
                ->join('teacher', 'teacher.teacher_id', 'courses.teacher_id')
                ->get();
            foreach ($courses as $id => $cou) {
                $count =$course_employeeModel->where('course_id', $cou->course_id)
                    ->count();
                $courses[$id]['total_employee']=$count;

            }
            $list_course[$course_cate->category_course_slug] = $courses;
        }

        $course_feedbackModel = new Course_feedback();


        echo '<pre>';
        print_r($list_teacher);die;


        return view('site.course_site.list_course', compact('course_categorise','list_course','list_teacher'));
    }

    public function showCourseDetail($course_slug)
    {
        return view('site.course_site.detail_course');
    }

    public function myCourse()
    {
        return view('site.course_site.my_course');
    }

    public function payment($course_slug)
    {
        return view('site.course_site.payment_course');
    }

    public function learingCourse($course_slug)
    {
        return view('site.course_site.learning_course');
    }

    static function getCourseByCateSlug(){

    }


}
