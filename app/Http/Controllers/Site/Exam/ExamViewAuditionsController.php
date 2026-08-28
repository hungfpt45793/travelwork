<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site\Exam;


use App\Entity\Category;
use App\Exam\CategoriesExam;
use App\Exam\CommentExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;



class ExamViewAuditionsController extends SiteController
{
    public function __construct(){
        parent::__construct();
        view()->share('menuTopsite', 'exam');
    }

    public function getTestAllExam(Request $request)
    {
        try{
                $exams = new Exam();
                $exams = $exams->select(
                    'exam.id_exam',
                    'code_exam',
                    'slug_exam',
                    'name_exam',
                    'intro_exam',
                    'id_cate_exam',
                    'time_exam',
                    'status_exam',
                    'view_exam',
                    'exam_type_id',
                    'exam_local_job_id'
                )
                    ->leftJoin('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
                    ->where('exam.bank_exam', '=', 1)
                    ->where('exam.status_exam', '=', 1);
            if(!empty($request->input('exam_type_id')))
            {
                $exam_type_id = $request->input('exam_type_id');
                $exams = $exams->where('exam.exam_type_id',$exam_type_id);
            }
            if(!empty($request->input('exam_local_job_id')))
            {

                $exam_local_job_id = $request->input('exam_local_job_id');
                $exams = $exams->where('exam.exam_local_job_id',$exam_local_job_id);
            }
                if(!empty($request->input('exam_name')))
                {
                    $exam_name = $request->input('exam_name');
                    $exams = $exams->where('exam.name_exam', 'like', '%'.$exam_name.'%');
                }
                $exams = $exams->distinct('exam.id_exam')->orderBy('id_exam','desc');
                $total = 0;
                $total = $exams->count('exam.id_exam');
                $exams = $exams->groupBy(
                    'exam.id_exam',
                    'code_exam',
                    'slug_exam',
                    'name_exam',
                    'intro_exam',
                    'id_cate_exam',
                    'time_exam',
                    'status_exam',
                    'view_exam',
                    'exam_type_id',
                    'exam_local_job_id'
                );
                $exams = $exams->paginate(20);
                $exams->appends(request()->query());
                $user = auth()->user();
            return view('site.exam.category_test', compact('exams','user','total'));
        }catch (\Exception $e)
        {
            return redirect('/')->with('errorExam','Không tìm thấy đề thi');
        }

    }

    public function getTestExam(Request $request ,$slug_exam)
    {
        $exams = new Exam();
        $exam = $exams->select('*')
            //where trang thai public hoac prive cua de thi
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.slug_exam' ,'=', $slug_exam)
            ->first();
        $view_exam = 1;
        if(!empty($exam))
        {
            $view_exam = intval($exam->view_exam) + 1;
        }
        $update = $exams->where('slug_exam' ,'=', $slug_exam)->update([
            'view_exam' => $view_exam
        ]);

        $categories_exams = New CategoriesExam();
        $categories_exams = $categories_exams->select('*')
            ->join('categories_join_exam','categories_join_exam.id_categories_exam' , '=' ,'categories_exam.id_cate_exam')
            ->where('categories_join_exam.id_exam' ,'=',$exam['id_exam'])
            ->get();

        $conments = new CommentExam();
        $conments = $conments->select('*')->where('id_exam',$exam['id_exam'])->get();
        return view('site.exam.exam_test_new',compact('exam','categories_exams','conments'));
    }
    public function getTestQuestion(Request $request ,$slug_exam)
    {
        $exam = new Exam();
        $exam = $exam->select('*')
//            ->join('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
//            ->join('categories_exam','categories_exam.id_cate_exam','=','categories_join_exam.id_categories_exam')
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.slug_exam' ,'=', $slug_exam)
            ->first();
        if (empty($exam)) {
            return redirect()->route('getTestAllExam')->with(
                'errorExam',
                'Đề thi không tồn tại hoặc chưa được công khai'
            );
        }
        $categories_exams = new CategoriesExam();
        $categories_exams = $categories_exams->select('*')
            ->join('categories_join_exam','categories_join_exam.id_categories_exam' , '=' ,'categories_exam.id_cate_exam')
            ->where('categories_join_exam.id_exam' ,'=',$exam->id_exam)
            ->get();

        $question = new Questions();
        $questions = $question->select('*')
            ->where('id_exam','=' , $exam->id_exam)
//            ->groupBy('')
            ->orderBy('type_ques','asc')
            ->get();
        $countQuestion = $question->select('*')
            ->where('id_exam','=' , $exam->id_exam)
            ->count();
        if ($countQuestion <= 0) {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('errorQuestion','Đề thi này chưa được tạo câu hỏi');
        }
        return view('site.exam.show_question_test',compact('exam','categories_exams','questions','countQuestion'));
    }
}
