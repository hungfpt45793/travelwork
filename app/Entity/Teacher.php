<?php

namespace App\Entity;

use App\Course\Course;
use App\Course\Courses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'teacher';
    protected $primaryKey = 'teacher_id';
    protected $fillable = [
        'teacher_id',
        'teacher_code',
        'teacher_name',
        'slug',
        'teacher_phone',
        'teacher_email',
        'teacher_images',
        'teacher_info',
        'province',
        'district',
        'address',
        'experience',
        'soft_skills',
        'birthday',
        'user_id',
        'gender',
        'information_verifier',
        'created_at',
        'updated_at',
        'deleted_at',
        'status_teacher_experience',
        'day_status_teacher_experience',
        'status_teacher_degree',
        'day_status_teacher_degree',
        'career_category_id',
        'business_type_id',
        'course_id',
        'status',
        'status_accounting',
        'is_delete',
        'teacher_status_id'
    ];

    public static function get_all_teacher($count)
    {
        $teacher = new Teacher();
        $list_teacher = $teacher->select('province', 'district', 'business_type_id', 'teacher_name', 'teacher_id', 'teacher_images', 'slug');
        $list_teacher = $list_teacher->orderBy('teacher.teacher_id', 'desc')->limit($count)->get();
        return $list_teacher;
    }

    public static function get_teacher_course($count)
    {
        $teacher = new Teacher();

        $list_teacher = $teacher->select('teacher.province', 'teacher.district', 'teacher.business_type_id', 'teacher.teacher_name', 'teacher.teacher_id', 'teacher.teacher_images', 'teacher.slug')
            ->join('courses','courses.teacher_id','teacher.teacher_id')
            ->orderBy('teacher.teacher_id', 'desc')
            ->distinct()
            ->limit($count)
            ->get();
        return $list_teacher;
    }

    public static function getexpteacher($teacher_id)
    {
        $nowYear = (int)date('Y');
        $listExp = Teacher_experience::select('*')
            ->where('teacher_id', $teacher_id)
            ->get();

        $exp = [];
        $exp[$teacher_id] = null;

        if (count($listExp) > 0) {
            $minYear = $nowYear;
            foreach ($listExp as $key => $value) {
                $star_year = (int)$value['star_working_time'];
                if ($star_year == 0) {
                    $minYear = $nowYear;
                } else {
                    if ($minYear > $star_year) {
                        $minYear = $star_year;
                    }
                }
            }
            $exp[$teacher_id] = $nowYear - $minYear;
        }
        if ($exp[$teacher_id] != null && $exp[$teacher_id] > 0) {
            $string2 = $exp[$teacher_id];
        } else {
            $string2 = '0';
        }
        // $string2 = '';
        // $string2 .= $exp[$teacher_id];
        return $string2;
    }

    public
    static function getTeacher_id($id_user)
    {
        $teacher = new Teacher();
        $teacher = $teacher->select('teacher_id', 'teacher_name', 'teacher_images', 'teacher_phone', 'teacher_email', 'address')->where('user_id', $id_user)->first();
        return $teacher;
    }

    public
    static function getTeacher_image($teacher_id)
    {
        $teacher = new Teacher();
        $teacher = $teacher->select('teacher_id', 'teacher_images')->where('teacher_id', $teacher_id)->first();
        return $teacher;
    }

    public
    static function getTeacher_ids($id_user)
    {
        $teacher = new Teacher();
        $teacher = $teacher->select('*')->where('user_id', $id_user)->first();
        return $teacher;
    }

    public
    static function getAllNew()
    {
        $teacher = new Teacher();
        $teacher = $teacher->select('teacher_id', 'teacher_name', 'teacher_images', 'slug', 'business_type_id', 'province', 'district')
            ->where('teacher.status', '!=', 1)
            ->orderBy('teacher_id', 'desc')
            ->limit(10)->get();
        return $teacher;
    }

    public
    static function getTeacherDetail($teacher_id)
    {
        $teacherModel = new Teacher();
        $teacher = $teacherModel->where('teacher_id', $teacher_id)->first();
        if (!isset($teacher))
            return [];

        $total_course = Courses::where('teacher_id', $teacher['teacher_id'])->count();
        $total_student = Courses::where('courses.teacher_id', $teacher['teacher_id'])
            ->join('course_employee', 'course_employee.course_id', 'courses.course_id')
            ->count();
        $teacher['total_course'] = $total_course;
        $teacher['total_student'] = $total_student;

        return $teacher;


    }

}
