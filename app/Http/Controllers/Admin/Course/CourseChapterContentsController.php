<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapter_contents;
use App\Course\Course_chapters;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Courses;
use App\Course\Questions_course_chapter_contents;
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

class CourseChapterContentsController extends AdminController
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

    public function store_chapter_content(Request $request)
    {
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
        return redirect()->back()->with('success', 'Thêm mới bài học thành công');
    }

    public function update_chapter_content(Request $request)
    {
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
        return redirect()->back()->with('success', 'Cập nhật bài học thành công');
    }

    public function delete_chapter_content(Request $request, $course_chapter_id)
    {
        $course_chapter = new Course_chapter_contents();
        $update = $course_chapter->where('course_content_id', $course_chapter_id)
            ->delete();
        return redirect()->back()->with('success', 'Xóa bài học thành công');
    }

    public function list_content_voucher(Request $request, $course_content_id)
    {

        $course_chapter = new Course_chapter_contents();
        $course_chapter = $course_chapter->where('course_content_id', $course_content_id)
            ->first();
        $course_chapter_name = Course_chapters::where('course_chapter_id', $course_chapter->course_chapter_id)->value('course_chapter_name');

        $course_voucher = new Course_content_voucher();
        $list_voucher = $course_voucher->select('*')->where('course_content_id', $course_content_id)->get();
        $total_voucher = $course_voucher->where('course_content_id', $course_content_id)->count();

        $course_voucher_answer = new Course_content_voucher_answer();
        $list_voucher_answer = $course_voucher_answer->select('*')->where('course_content_id', $course_content_id)->get();
        $total_voucher_answer = $course_voucher_answer->where('course_content_id', $course_content_id)->count();

        $course_title = Courses::where('course_id', $course_chapter->course_id)->value('course_title');

//        echo '<pre>';
//        print_r($course_chapter);die;
        return view('admin.course.course_chapter_content.list', compact('course_chapter', 'list_voucher', 'total_voucher', 'course_title', 'course_chapter_name', 'list_voucher_answer', 'total_voucher_answer'));

    }

    //danh sách câu hỏi trắc nghiệm
    public function list_question_content(Request $request, $course_content_id)
    {
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $course = Courses::where('course_id', $course_content->course_id)->first();
        $course_chapter = Course_chapters::where('course_chapter_id', $course_content->course_chapter_id)->first();

        $list_question = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->get();
        $total_question = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->count();

//        echo '<pre>';
//        print_r($course_chapter);die;
        return view('admin.course.course_question.list', compact('course_content', 'course', 'course_chapter', 'list_question', 'total_question'));

    }

    public function add_question_content(Request $request, $course_content_id)
    {
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
//        $course = Courses::where('course_id',$course_content->course_id)->first();
//        $course_chapter = Course_chapters::where('course_chapter_id',$course_content->course_chapter_id)->first();

        return view('admin.course.course_question.add', compact('course_content'));

    }

    public function create_question_content(Request $request, $course_content_id)
    {
        $course_content = Course_chapter_contents::where('course_content_id', $course_content_id)->first();
        $question = new Questions_course_chapter_contents();
        $question_idZero = $question->insertGetId([
            'user_id' => Auth::user()->id,
            'course_id' => $course_content->course_id,
            'course_content_id' => $course_content->course_content_id,
            'course_chapter_id' => $course_content->course_chapter_id,
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
        return redirect(route('list_question_content', ['course_content_id' => $course_content_id]))->with('suscees', 'Thêm thành công');
    }

    public function edit_question_content(Request $request, $id_ques)
    {
        $question = Questions_course_chapter_contents::where('id_ques', $id_ques)->first();
        $course_content = Course_chapter_contents::where('course_content_id', $question->course_content_id)->first();
        return view('admin.course.course_question.edit', compact('course_content', 'question'));


    }

    public function update_question_content(Request $request, $id_ques)
    {
//        echo 1;die;
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
        return redirect(route('list_question_content', ['course_content_id' => $course_content_id]))->with('suscees', 'Cập nhật thành công');
    }

    public function delete_question_content(Request $request, $id_ques)
    {
        $question = new Questions_course_chapter_contents();
        $course_content_id = $question->where('id_ques', $id_ques)->value('course_content_id');
        $question_idZero = $question->where('id_ques', $id_ques)->delete();
        return redirect(route('list_question_content', ['course_content_id' => $course_content_id]))->with('suscees', 'Xóa thành công');

    }

}
