<?php

namespace App\Http\Controllers\Site\Course;

use App\Course\Course;
use App\Entity\Employee;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use App\Entity\Invite;
use App\Entity\MailConfig;
use App\Entity\SettingGetfly;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
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


class CourseViewController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

//    check quyền nhà tuyển dụng

    public function showCourse(Request $request)
    {
        $course = new Course;
        $list_course = $course->select('course.*', 'teacher.teacher_name', 'teacher.teacher_images', 'teacher.career_category_id', 'teacher.province', 'teacher.district')->join('teacher', 'teacher.teacher_id', '=', 'course.teacher_id');

        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $list_course = $list_course->where('teacher.career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $list_course = $list_course->where('teacher.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $list_course = $list_course->where('teacher.district', $district);
        }

        $list_course = $list_course->orderBy('course.course_id', 'desc')->paginate(16);
        $list_course->appends(request()->query());
        return view('site.course.list_course', compact('list_course'));
    }

    public function detailCourse($slug)
    {
        $course = new Course;
        $course = $course->select('course.*', 'teacher.teacher_name', 'teacher.teacher_images')->join('teacher', 'teacher.teacher_id', '=', 'course.teacher_id')->orderBy('course.course_id', 'desc')->where('course.slug', $slug)->first();

        $teacher = new Teacher();
        $teacher = $teacher->select('*')->where('teacher_id', $course->teacher_id)->first();

//        kinh nghiem giáo viên
        $teacher_experience = new Teacher_experience();
        $teacher_experience = $teacher_experience->select('*')->orderBy('experience_id', 'asc')->where('teacher_id', $course->teacher_id)->get();
//        trình độ giáo viên
        $teacher_specialize = new Teacher_specialize();
        $teacher_specialize = $teacher_specialize->select('*')->orderBy('specialize_id', 'asc')->where('teacher_id', $course->teacher_id)->get();
//        khóa học của giáo viên

        $list_course = $course->select('course.*', 'teacher.teacher_name', 'teacher.teacher_images')->join('teacher', 'teacher.teacher_id', '=', 'course.teacher_id')->where('course.teacher_id', $teacher->teacher_id)->orderBy('course.course_id', 'desc')->limit(8)->get();

        return view('site.course.detail_course', compact('course', 'teacher', 'teacher_experience', 'teacher_specialize', 'list_course'));
    }

    public function regedit_course(Request $request, $course_id)
    {
        try {
            $user = Auth::user();
            $user_id = Auth::user()->id;
            $employee = new Employee();
            $employee = $employee->select('*')->where('user_id', $user_id)->first();
            $course = new Course();
            $course = $course->where('course_id', $course_id)->update([
                'employee_id' => $employee->employee_id
            ]);
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
            ]);
        }

    }
}
