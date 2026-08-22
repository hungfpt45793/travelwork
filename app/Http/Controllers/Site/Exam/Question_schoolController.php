<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site\Exam;


use App\Entity\Category;
use App\Entity\Teacher_schools;
use App\Exam\CategoriesExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\Questions_school;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;


class Question_schoolController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect('/');
            }
            $this->id_user = Auth::user()->id;
            view()->share('menuTopsite', 'exam');
            return $next($request);
        });
    }

//    public function index()
//    {
//        try {
//            $e_xams = Exam::select('*')
//                ->join('users', 'users.id', '=', 'exam.id_user')
//                ->paginate(15);
//        } catch (\Exception $e) {
//            $categories = null;
////            Error::setErrorMessage('Hiển thị danh mục xảy ra lỗi.');
//            Log::error('http->Admin->CategoryController->index: Hiển thị danh mục xảy ra lỗi');
//        } finally {
//            return view('admin.exam.list', compact('e_xams'));
//        }
//    }
//    Danh sách câu hỏi
    public function list_question_school_zero(Request $request)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();

//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 0)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if($request->input('sub_id'))
        {
            $question_zero = $question_zero->where('sub_id',$request->input('sub_id'));
        }
//
        $question_zero = $question_zero->orderBy('sub_id', 'asc');
        $question_zero = $question_zero->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();
        $question_zero = $question_zero->get();
        return view('site.exam_school.questions.list_question_school_zero', compact('total_zero', 'question_zero'));
    }

    public function list_question_school_one(Request $request)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();

//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 1)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
             if($request->input('sub_id'))
             {
                 $question_zero = $question_zero->where('sub_id',$request->input('sub_id'));
             }
        $question_zero = $question_zero->orderBy('sub_id', 'asc');
        $question_zero = $question_zero->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();
        $question_zero = $question_zero->get();
        return view('site.exam_school.questions.list_question_school_one', compact('total_zero', 'question_zero'));
    }

    public function list_question_school_two(Request $request)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();

//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 2)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if($request->input('sub_id'))
        {
            $question_zero = $question_zero->where('sub_id',$request->input('sub_id'));
        }
        $question_zero = $question_zero->orderBy('sub_id', 'asc');
        $question_zero = $question_zero->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();
        $question_zero = $question_zero->get();
        return view('site.exam_school.questions.list_question_school_two', compact('total_zero', 'question_zero'));
    }

    public function list_question_school_three(Request $request)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();

//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 3)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if($request->input('sub_id'))
        {
            $question_zero = $question_zero->where('sub_id',$request->input('sub_id'));
        }
        $question_zero = $question_zero->orderBy('sub_id', 'asc');
        $question_zero = $question_zero->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();
        $question_zero = $question_zero->get();


        return view('site.exam_school.questions.list_question_school_three', compact('total_zero', 'question_zero'));
    }

    public function create_question_school($type_question)
    {
        if ($type_question == 0) {
            return view('site.exam_school.questions.create_question_zero', compact('type_question'));
        }if ($type_question == 1) {
            return view('site.exam_school.questions.create_question_one', compact('type_question'));
        }if ($type_question == 2) {
            return view('site.exam_school.questions.create_question_two', compact('type_question'));
        }if ($type_question == 3) {
            return view('site.exam_school.questions.create_question_three', compact('type_question'));
        }
        return redirect(route('list_question_school_zero'))->with('error', 'Vui lòng thử lại chức năng này !');
    }

    public function store_question_school(Request $request)
    {
//        echo $request->input('sub_id');die();
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('teacher_sc_id', 'user_id')->where('user_id', $id)->first();
//        echo '<pre>';
//        print_r($teacher_school);die();

        $question = new Questions_school();
        $type_ques = $request->input('type_ques');
        $name = $request->input('name_ques');
        if ($type_ques == 0) {
            $this->validate($request, [
                'name_ques' => 'required',
                'answer1' => 'required',
                'answer2' => 'required',
            ]);
            $question_idZero = $question->insertGetId([
                'type_ques' => $type_ques,
                'name_ques' => $request->input('name_ques'),
                'show_answer_ques' => $request->input('show_answer_ques'),
                'teacher_sc_id' => $teacher_school->teacher_sc_id,
                'answer1' => $request->input('answer1'),
                'answer2' => $request->input('answer2'),
                'answer3' => $request->input('answer3'),
                'answer4' => $request->input('answer4'),
                'correct_answer' => $request->input('correct_answer'),
                'sub_id' => $request->input('sub_id'),
                'created_at' => new \DateTime(),
            ]);
            if ($question_idZero > 0) {
                return redirect(route('list_question_school_zero'))->with('suscees', 'Thêm mới câu hỏi thành công !');
            } else {
                return redirect(route('list_question_school_zero'))->with('error', 'Thêm mới câu hỏi thất bại !');
            }
        }
        if ($type_ques == 1) {
            $this->validate($request, [
                'name_ques' => 'required',
                'answer1' => 'required',
                'answer2' => 'required',
            ]);
            $question_idOne = $question->insertGetId([
                'type_ques' => $type_ques,
                'name_ques' => $request->input('name_ques'),
                'show_answer_ques' => $request->input('show_answer_ques'),
                'teacher_sc_id' => $teacher_school->teacher_sc_id,
                'answer1' => $request->input('answer1'),
                'answer2' => $request->input('answer2'),
                'answer3' => $request->input('answer3'),
                'answer4' => $request->input('answer4'),
                'correct_answer' => $request->input('correct_answer'),
                'sub_id' => $request->input('sub_id'),
                'created_at' => new \DateTime(),
            ]);
            if ($question_idOne > 0) {
                return redirect(route('list_question_school_one'))->with('suscees', 'Thêm mới câu hỏi thành công !');
            } else {
                return redirect(route('list_question_school_one'))->with('error', 'Thêm mới câu hỏi thất bại !');
            }

        }
        if ($type_ques == 2) {
            $this->validate($request, [
                'name_ques' => 'required',
                'answer1' => 'required',
                'answer2' => 'required',
            ]);
            $question_idTwo = $question->insertGetId([
                'type_ques' => $type_ques,
                'name_ques' => $request->input('name_ques'),
                'show_answer_ques' => $request->input('show_answer_ques'),
                'teacher_sc_id' => $teacher_school->teacher_sc_id,
                'answer1' => $request->input('answer1'),
                'answer2' => $request->input('answer2'),
                'answer3' => $request->input('answer3'),
                'answer4' => $request->input('answer4'),
                'correct_answer' => $request->input('correct_answer'),
                'sub_id' => $request->input('sub_id'),
                'created_at' => new \DateTime(),
            ]);
            if ($question_idTwo > 0) {
                return redirect(route('list_question_school_two'))->with('suscees', 'Thêm mới câu hỏi thành công !');
            } else {
                return redirect(route('list_question_school_two'))->with('error', 'Thêm mới câu hỏi thất bại !');
            }

        }
        if ($type_ques == 3) {
            $this->validate($request, [
                'name_ques' => 'required'
            ]);
            $question_idThree = $question->insertGetId([
                'type_ques' => $type_ques,
                'name_ques' => $request->input('name_ques'),
                'show_answer_ques' => $request->input('show_answer_ques'),
                'teacher_sc_id' => $teacher_school->teacher_sc_id,
                'correct_answer' => $request->input('correct_answer'),
                'sub_id' => $request->input('sub_id'),
                'created_at' => new \DateTime(),
            ]);
            if ($question_idThree > 0) {
                return redirect(route('list_question_school_three'))->with('suscees', 'Thêm mới câu hỏi thành công !');
            } else {
                return redirect(route('list_question_school_three'))->with('error', 'Thêm mới câu hỏi thất bại !');
            }

        }
    }

    public function edit_question_school($ques_id)
    {
        try {
            $id = Auth::user()->id;
            $teacher_school = Teacher_schools::select('teacher_sc_id', 'user_id')->where('user_id', $id)->first();
            $questions = new Questions_school();
            $question = $questions->select('*')
                ->where('id_ques', $ques_id)
                ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                ->first();
            if (!empty($question)) {
                if($question->type_ques == 3)
                {
                    return view('site.exam_school.questions.edit_question_three', compact('question'));
                }
                return view('site.exam_school.questions.edit_question_zero', compact('question'));
            } else {
                return redirect(route('list_question_school_zero'))->with('error', 'Không tìm thấy câu hỏi này !');
            }

        } catch (\Exception $exception) {
            return redirect(route('list_question_school_zero'))->with('error', 'Không tìm thấy câu hỏi này !');
        }
    }

    public function update_question_school(Request $request, $ques_id)
    {

        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('teacher_sc_id', 'user_id')->where('user_id', $id)->first();
        $questions = new Questions_school();
        $check_question_school = $questions->where('id_ques', $ques_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)->first();
        $type_ques = $check_question_school->type_ques;


        $updatequestion = $questions->where('id_ques', $ques_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->update([
                'name_ques' => $request->input('name_ques'),
                'show_answer_ques' => $request->input('show_answer_ques'),
                'type_ques' => $type_ques,
                'answer1' => $request->input('answer1'),
                'answer2' => $request->input('answer2'),
                'answer3' => $request->input('answer3'),
                'answer4' => $request->input('answer4'),
                'correct_answer' => $request->input('correct_answer'),
                'sub_id' => $request->input('sub_id'),
                'updated_at' => new \DateTime(),
            ]);
        if ($type_ques == 0) {
            return redirect(route('list_question_school_zero'))->with('suscees', 'Cập nhật câu hỏi thành công !');
        }
        if ($type_ques == 1) {
            return redirect(route('list_question_school_one'))->with('suscees', 'Cập nhật câu hỏi thành công !');
        }
        if ($type_ques == 2) {
            return redirect(route('list_question_school_two'))->with('suscees', 'Cập nhật câu hỏi thành công !');
        }
        if ($type_ques == 3) {
            return redirect(route('list_question_school_three'))->with('suscees', 'Cập nhật câu hỏi thành công !');
        }

//                return redirect(route('list_question_school_zero'))->with('error','Thêm mới câu hỏi thất bại !');

    }

    public function delete_question(Request $request ,$ques_id)
    {
        try
        {
            $id = Auth::user()->id;
            $teacher_school = Teacher_schools::select('teacher_sc_id', 'user_id')->where('user_id', $id)->first();
            $question = new Questions_school();
            $question_find = $question
                ->where('id_ques', $ques_id)
                ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                ->first();
            $type_ques = $question_find['type_ques'];
            if ($type_ques == 0) {
                $delete_ques = $question
                    ->where('id_ques', $ques_id)
                    ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                    ->delete();
                return redirect(route('list_question_school_zero'))->with('suscees', 'Xóa câu hỏi thành công !');
            }
            if ($type_ques == 1) {
                $delete_ques = $question
                    ->where('id_ques', $ques_id)
                    ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                    ->delete();
                return redirect(route('list_question_school_one'))->with('suscees', 'Xóa câu hỏi thành công !');
            }

            if ($type_ques == 2) {
                $delete_ques = $question
                    ->where('id_ques', $ques_id)
                    ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                    ->delete();
                return redirect(route('list_question_school_two'))->with('suscees', 'Xóa câu hỏi thành công !');
            }
            if ($type_ques == 3) {
                $delete_ques = $question
                    ->where('id_ques', $ques_id)
                    ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                    ->delete();
                return redirect(route('list_question_school_three'))->with('suscees', 'Xóa câu hỏi thành công !');
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->with('error', 'Xóa câu hỏi thất bại!');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $question = new Questions();
            $id_exam = $request->input('id_exam');
            $exam = new Exam();

            $checklever = $this->checkRoleUser($id_exam);
            if ($checklever == 1) {
                return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
            }
            $type_ques = $request->input('type_ques');
            $name = $request->input('name_ques');
            if ($type_ques == 0) {
                $this->validate($request, [
                    'name_ques' => 'required',
                    'answer1' => 'required',
                    'answer2' => 'required',
                ]);
                $question_idZero = $question->insertGetId([
                    'id_exam' => $id_exam,
                    'type_ques' => $type_ques,
                    'name_ques' => $request->input('name_ques'),
                    'show_answer_ques' => $request->input('show_answer_ques'),
                    'answer1' => $request->input('answer1'),
                    'answer2' => $request->input('answer2'),
                    'answer3' => $request->input('answer3'),
                    'answer4' => $request->input('answer4'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
                if ($question_idZero > 0) {
                    return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi trắc nghiệm thành công !');
                } else {
                    return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('error', 'Thêm mới câu hỏi trắc nghiệm thất bại !');
                }
            }
            if ($type_ques == 1) {
                $this->validate($request, [
                    'name_ques' => 'required',
                    'answer1' => 'required',
                    'answer2' => 'required',
                ]);
                $question_idOne = $question->insertGetId([
                    'id_exam' => $id_exam,
                    'type_ques' => $type_ques,
                    'name_ques' => $request->input('name_ques'),
                    'show_answer_ques' => $request->input('show_answer_ques'),
                    'answer1' => $request->input('answer1'),
                    'answer2' => $request->input('answer2'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
                if ($question_idOne > 0) {
                    return redirect(route('getAllQuestionsOne', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi đúng sai thành công !');
                } else {
                    return redirect(route('getAllQuestionsOne', ['id_exam' => $id_exam]))->with('error', 'Thêm mới câu hỏi đúng sai thất bại !');
                }

            }
            if ($type_ques == 2) {
                $this->validate($request, [
                    'name_ques' => 'required'
                ]);
                $question_idTwo = $question->insertGetId([
                    'id_exam' => $id_exam,
                    'type_ques' => $type_ques,
                    'name_ques' => $request->input('name_ques'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
                if ($question_idTwo > 0) {
                    return redirect(route('getAllQuestionsTwo', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi tự luận thành công !');
                } else {
                    return redirect(route('getAllQuestionsTwo', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi tự luận thất bại !');
                }

            }
        }
        catch (\Exception $e)
        {
            return redirect(route('getAllQuestions', ['id_exam' => $id_exam]))->with('error', 'Bạn đã thêm câu hỏi thất bại ! vui lòng nhập lại đây đủ nội dung của câu hỏi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Responsede
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
//

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_ques)
    {
        $id_exam = $request->input('id_exam');
        $checklever = $this->checkRoleUser($id_exam);
        if ($checklever == 1) {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
        $question = new Questions();
        $exam = new Exam();
        $type_ques = $request->input('type_ques');
        $name = $request->input('name_ques');


        if ($type_ques == 0) {
            $this->validate($request, [
                'name_ques' => 'required',
                'answer1' => 'required',
                'answer2' => 'required',
            ]);
            $updatequestion = $question->where('id_exam', '=', $id_exam)
                ->where('id_ques', '=', $id_ques)
                ->update([
                    'name_ques' => $request->input('name_ques'),
                    'show_answer_ques' => $request->input('show_answer_ques'),
                    'answer1' => $request->input('answer1'),
                    'answer2' => $request->input('answer2'),
                    'answer3' => $request->input('answer3'),
                    'answer4' => $request->input('answer4'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            if ($updatequestion) {
                return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi trắc  nghiệm thành công');
            } else {
                return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi thất bại');
            }


        }
        if ($type_ques == 1) {
            $this->validate($request, [
                'name_ques' => 'required',
                'answer1' => 'required',
                'answer2' => 'required',
            ]);
            $updatequestionOne = $question->where('id_exam', '=', $id_exam)
                ->where('id_ques', '=', $id_ques)
                ->update([
                    'name_ques' => $request->input('name_ques'),
                    'show_answer_ques' => $request->input('show_answer_ques'),
                    'answer1' => $request->input('answer1'),
                    'answer2' => $request->input('answer2'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            if ($updatequestionOne) {
                return redirect(route('getAllQuestionsOne', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi đúng sai thành công');
            } else {
                return redirect(route('getAllQuestionsOne', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi đúng sai thất bại');
            }
        }
        if ($type_ques == 2) {
            $this->validate($request, [
                'name_ques' => 'required',
            ]);
            $questionTwo = $question->where('id_exam', '=', $id_exam)
                ->where('id_ques', '=', $id_ques)
                ->update([
                    'name_ques' => $request->input('name_ques'),
                    'show_answer_ques' => $request->input('show_answer_ques'),
                    'correct_answer' => $request->input('correct_answer'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            if ($questionTwo) {
                return redirect(route('getAllQuestionsTwo', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi tự luận thành công');
            } else {
                return redirect(route('getAllQuestionsTwo', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi tự luận thất bại');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_ques)
    {
        try {

            $question = new Questions();
            $question_find = $question->where('id_ques', '=', $id_ques)->first();
            $id_exam = $question_find['id_exam'];

            $count = $question->select('*')->where('id_exam', $id_exam)->count();
            $exam = new Exam();
            $checklever = $this->checkRoleUser($id_exam);
            if ($checklever == 1) {
                return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
            }
            $name = $question_find['name_ques'];
            $question = $question->where('id_ques', '=', $id_ques)
                ->delete();
            $type_ques = $question_find['type_ques'];
            if ($type_ques == 0) {
                return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi  trắc nghiệm thành công ');
            }
            if ($type_ques == 1) {
                return redirect(route('getAllQuestionsOne', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi đúng sai thành công ');
            }
            if ($type_ques == 2) {
                return redirect(route('getAllQuestionsTwo', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi tự luận thành công ');
            }

        } catch (\Exception $e) {
            return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('
            ', 'Bạn đã xóa câu hỏi thất bại ');
        }
    }

//    check user tao de thi

    public function getAllQuestionsZero(Request $request, $id_exam)
    {
        //lay ra quyen de an ham sua xoa copy
        $checklever = $this->checkRoleUser($id_exam);
        $user = Auth::user();
        $exam = new Exam();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->first();
        $question = new Questions();
//        câu hỏi trắc nghiệm
        $question_1 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 0)
            ->get();
        return view('site.exam_admin_site.questions.danh-sach-cau-hoi-trac-nghiem', compact('exam', 'question_1', 'checklever'));
    }

    public function getAllQuestionsOne(Request $request, $id_exam)
    {
        //lay ra quyen de an ham sua xoa copy
        $checklever = $this->checkRoleUser($id_exam);
        $user = Auth::user();
        $exam = new Exam();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->first();
//        lấy về danh sách câu hỏi thuộc id_exam
        $question = new Questions();
//        câu hỏi trắc nghiệm
        $question_1 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 1)
            ->get();
        return view('site.exam_admin_site.questions.danh-sach-cau-hoi-dung-sai', compact('exam', 'question_1', 'checklever'));
    }

    public function getAllQuestionsTwo(Request $request, $id_exam)
    {
        //lay ra quyen de an ham sua xoa copy
        $checklever = $this->checkRoleUser($id_exam);
        $user = Auth::user();
        $exam = new Exam();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->first();

//        lấy về danh sách câu hỏi thuộc id_exam
        $question = new Questions();
//        câu hỏi trắc nghiệm
        $question_1 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 2)
            ->get();
        return view('site.exam_admin_site.questions.danh-sach-cau-hoi-tu-luan', compact('exam', 'question_1', 'checklever'));
    }

    //check quyen xem co phai la user tao de thi không
    public function createQuestion(Request $request, $id_exam)
    {
        $checklever = $this->checkRoleUser($id_exam);
        if ($checklever == 1) {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
        if ($checklever == 1) {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
        $type = 0;
        if (!isset($_GET['type']) or $_GET['type'] == '') {
            return redirect(route('getAllQuestionsZero', ['id_exam' => $id_exam]))->with('error', 'Không thể thêm mới câu hỏi');
        } else {
            $type = intval($_GET['type']);
        }
        if ($type > 2 or $type < 0) {
            $type = 0;
        }
        $exams = new Exam();
        $exam = $exams->select('*')->where('id_exam', $id_exam)->first();
        return view('site.exam_admin_site.add_question.them-cau-hoi-trac-nghiem', compact('exam', 'type'));
    }

    public function editQuestion(Request $request, $id_ques)
    {
        try {
            $exams = new Exam();
            $questions = new Questions();
            $question = $questions->select('*')->where('id_ques', $id_ques)->first();
            $id = Auth::user()->id;
            $checklever = $this->checkRoleUser($question->id_exam);
            if ($checklever == 1) {
                return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
            }
            if ($question->type_ques > 2 or $question->type_ques < 0) {
                return redirect(route('showExam'))->with('error', 'Không tồn tại câu hỏi này !');
            }
            $exam = $exams->select('*')->where('id_exam', $question->id_exam)->first();
            return view('site.exam_admin_site.add_question.sua-cau-hoi-trac-nghiem', compact('exam', 'question'));
        } catch (\Exception $exception) {
            return redirect(route('showExam'))->with('error', 'Không tồn tại câu hỏi này !');
        }
    }

    public function copyQuestion(Request $request, $id_ques)
    {
        try {
            $exams = new Exam();
            $questions = new Questions();
            $question = $questions->select('*')->where('id_ques', $id_ques)->first();
            $checklever = $this->checkRoleUser($question->id_exam);
            if ($checklever == 1) {
                return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
            }
            if ($question->type_ques > 2 or $question->type_ques < 0) {
                return redirect(route('showExam'))->with('error', 'Không tồn tại câu hỏi này !');
            }
            $exam = $exams->select('*')->where('id_exam', $question->id_exam)->first();
            return view('site.exam_admin_site.add_question.copy-cau-hoi-trac-nghiem', compact('exam', 'question'));
        } catch (\Exception $exception) {
            return redirect(route('showExam'))->with('error', 'Không tồn tại câu hỏi này !');
        }
    }

//    phân quyên sửa đề thi câu hỏi
    private function checkRoleUser($id_exam)
    {
        $id = Auth::user()->id;
        $exams = new Exam();
        $exam = $exams->select('id_exam', 'id_user')
            ->where('id_user', $id)
            ->where('id_exam', $id_exam)
            ->count();
//        return $exam;
        if ($exam < 1) {
            return 1;
        } else {
            return 0;
        }
    }
    public function list_type_question_school(Request $request , $type_ques)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();
        $total_question = 0;
        $list_question = Questions_school::select('*')
            ->where('type_ques', $type_ques)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if($request->input('sub_id'))
        {
            $list_question = $list_question->where('sub_id',$request->input('sub_id'));
        }
        $list_question =$list_question ->orderBy('id_ques', 'asc');
        $total_question = $list_question->count();
        $list_question = $list_question->paginate(20);
        return view('site.exam_school.questions.list_type_question_school', compact('type_ques', 'list_question','total_question'));
    }
    public function ajax_change_type_question(Request $request)
    {
        try
        {
            $id = Auth::user()->id;
            $teacher_school = Teacher_schools::select('*')->where('user_id', $id)->first();
            $list_question = Questions_school::where('id_ques', $request->input('id_ques'))
                ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                ->update([
                    'type_ques' => $request->input('type_ques'),
                    'updated_at' => new \DateTime()
                ]);

            return response()->json([
                'status' => 200,
                'message' => 'thành công'
            ],200);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'message' => 'thất bại'
            ],400);
        }

    }


}
