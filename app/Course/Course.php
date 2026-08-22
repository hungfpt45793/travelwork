<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $table = 'course';
    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course_id',
        'course_code',
        'course_name',
        'slug',
        'course_image',
        'course_intro',
        'course_content',
        'course_price',
        'course_time',
        'title_detail1',  //⦁	Đăng ký học ngay -> Đăng ký tham gia nhóm
        'title_detail2', //⦁	 Sở hữu khóa học trọn đời -> Phí thành viên đóng linh hoạt
        'title_detail3', //⦁	 Khoá học này dành cho -> Nhóm Facebook này dành cho
        'title_detail4', //⦁	 Bạn sẽ nhận được gì nếu đăng ký khóa học này -> Bạn sẽ nhận được gì nếu tham gia nhóm Facebook này
        'title_detail5', //⦁	 Nội dung khoá học -> Những nội dung được hỗ trợ trả lời trong nhóm
        'created_at',
        'updated_at',
        'day_res',
    ];
    public static function checkALl($course_id,$employee_id)
    {
        $course = new Course();
        $course = $course->select('*')->where('course_id',$course_id)->where('employee_id',$employee_id)->count();
        return $course;
    }
}
