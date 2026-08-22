<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Exam\Answers;
use App\Exam\CategoriesExam;
use App\Exam\CategoriesJoinExam;
use App\Exam\Exam;
use App\Exam\Questions;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;
use Yajra\DataTables\DataTables;

class QuestionController extends \App\Http\Controllers\Admin\AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'exam');

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }
    public function getQuestionZero($id_exam)
    {

//        try{
            $question = new Questions();
            $questionZero =  $question->select('*')->where('id_exam',$id_exam)->where('type_ques',0)->get();
            return View('admin.exam.question.cauhoi-tracnghiem',compact('questionZero','id_exam'));
//        }
//        catch (\Exception $e)
//        {
//            return redirect(route('exam.index'))->with('erorr', 'Không tìm thấy câu hỏi');
//        }

    }
    public function getQuestionOne($id_exam)
    {
        try{
            $question = new Questions();
            $questionOne =  $question->select('*')->where('id_exam',$id_exam)->where('type_ques',1)->get();
            return View('admin.exam.question.cauhoi-dungsai',compact('questionOne','id_exam'));
        }

        catch (\Exception $e)
        {
            return redirect(route('exam.index'))->with('erorr', 'Không tìm thấy câu hỏi');
        }
    }
    public function getQuestionTwo($id_exam)
    {
        try{
            $question = new Questions();
            $questionTwo =  $question->select('*')->where('id_exam',$id_exam)->where('type_ques',2)->get();
            return View('admin.exam.question.cauhoi-tuluan',compact('questionTwo','id_exam'));
        }
        catch (\Exception $e)
        {
            return redirect(route('exam.index'))->with('erorr', 'Không tìm thấy câu hỏi');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function createQuestionAdmin(Request $request, $id_exam)
    {
        $type = 0;
        if (!isset($_GET['type']) or $_GET['type'] == '') {
            return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('error', 'Không thể thêm mới câu hỏi');
        } else {
            $type = intval($_GET['type']);
        }
        if ($type > 2 or $type < 0) {
            $type = 0;
        }
        $exams = new Exam();
        $exam = $exams->select('*')->where('id_exam', $id_exam)->first();
        return view('admin.exam.question.add', compact('exam', 'type','id_exam'));
    }

    public function editQuestionAdmin(Request $request, $id_ques)
    {
        try {
            $exams = new Exam();
            $questions = new Questions();
            $question = $questions->select('*')->where('id_ques', $id_ques)->first();
            $id = Auth::user()->id;
            if ($question->type_ques > 2 or $question->type_ques < 0) {
                return redirect(route('exam.index'))->with('error', 'Không tồn tại câu hỏi này !');
            }
            $exam = $exams->select('*')->where('id_exam', $question->id_exam)->first();
            $id_exam = $question->id_exam;
            $type = $question->type_ques;
            return view('admin.exam.question.edit', compact('exam', 'question','id_exam','type'));
        } catch (\Exception $exception) {
            return redirect(route('exam.index'))->with('error', 'Không tồn tại câu hỏi này !');
        }
    }
    public function copyQuestionAdmin(Request $request, $id_ques)
    {
        try {
            $exams = new Exam();
            $questions = new Questions();
            $question = $questions->select('*')->where('id_ques', $id_ques)->first();
            if ($question->type_ques > 2 or $question->type_ques < 0) {
                return redirect(route('showExam'))->with('error', 'Không tồn tại câu hỏi này !');
            }
            $exam = $exams->select('*')->where('id_exam', $question->id_exam)->first();
            $id_exam = $exam->id_exam;
            $type = $question->type_ques;
            return view('admin.exam.question.copy', compact('exam', 'question','id_exam','type'));
        } catch (\Exception $exception) {
            return redirect(route('exam.index'))->with('error', 'Không tồn tại câu hỏi này !');
        }
    }



    public function store(Request $request)
    {
//        try {
        $question = new Questions();
        $id_exam = $request->input('id_exam');
        $exam = new Exam();
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
                return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi trắc nghiệm thành công !');
            } else {
                return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('error', 'Thêm mới câu hỏi trắc nghiệm thất bại !');
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
                return redirect(route('getQuestionOne', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi đúng sai thành công !');
            } else {
                return redirect(route('getQuestionOne', ['id_exam' => $id_exam]))->with('error', 'Thêm mới câu hỏi đúng sai thất bại !');
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
                return redirect(route('getQuestionTwo', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi tự luận thành công !');
            } else {
                return redirect(route('getQuestionTwo', ['id_exam' => $id_exam]))->with('suscees', 'Thêm mới câu hỏi tự luận thất bại !');
            }

        }
//        }
//        catch (\Exception $e)
//        {
//            return redirect(route('getAllQuestions', ['id_exam' => $id_exam]))->with('error', 'Bạn đã thêm câu hỏi thất bại ! vui lòng nhập lại đây đủ nội dung của câu hỏi');
//        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
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

    public function edit(Request $request, $id_exam)
    {
        try{
            $user = Auth::user();
            $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
            $exam = new Exam();
            $exam = $exam->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('id_user', '=', $user->id)
                ->first();
            if(empty($exam))
            {
                return redirect( route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
            }
            $categories_join_exams = new CategoriesJoinExam();
            $categories_join_exams = $categories_join_exams->select('*')
                ->where('id_exam', '=', $id_exam)
                ->get();

            $categories_join_exam = array();
            foreach ($categories_join_exams as $cate) {
                $categories_join_exam[] = $cate->id_categories_exam;
            }
//        lấy về danh sách câu hỏi thuộc id_exam
            $question = new Questions();

//        câu hỏi trắc nghiệm
            $question_1 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 0)
                ->get();
            $question_2 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 1)
                ->get();
            $question_3 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 2)
                ->get();
            return view('site.questions.anh-sach-cau-hoi', compact('categories_exam', 'exam', 'categories_join_exam', 'question_1','question_2','question_3'));
        }catch (\Exception $e)
        {
            Log::error('Loi');
            return redirect( route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
        }
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
                return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi trắc  nghiệm thành công');
            } else {
                return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi thất bại');
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
                return redirect(route('getQuestionOne', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi đúng sai thành công');
            } else {
                return redirect(route('getQuestionOne', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi đúng sai thất bại');
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
                return redirect(route('getQuestionTwo', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã sửa câu hỏi tự luận thành công');
            } else {
                return redirect(route('getQuestionTwo', ['id_exam' => $id_exam]))->with('error', 'Bạn đã sửa câu hỏi tự luận thất bại');
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

            $count= $question->select('*')->where('id_exam',$id_exam)->count();
            $exam = new Exam();
            $name = $question_find['name_ques'];
            $question = $question->where('id_ques', '=', $id_ques)
                ->delete();
            $type_ques = $question_find['type_ques'];
            if ($type_ques == 0) {
                return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi  trắc nghiệm thành công ');
            }
            if ($type_ques == 1) {
                return redirect(route('getQuestionOne', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi đúng sai thành công ');
            }
            if ($type_ques == 2) {
                return redirect(route('getQuestionTwo', ['id_exam' => $id_exam]))->with('suscees', 'Bạn đã xóa câu hỏi tự luận thành công ');
            }

        } catch (\Exception $e) {
            return redirect(route('getQuestionZero', ['id_exam' => $id_exam]))->with('
            ', 'Bạn đã xóa câu hỏi thất bại ');
        }
    }

}
