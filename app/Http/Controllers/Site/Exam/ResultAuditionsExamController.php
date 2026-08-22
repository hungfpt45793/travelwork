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
use App\Exam\DetailResultExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\ResultExam;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;


class ResultAuditionsExamController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'exam');

    }

    public function createTestResult(Request $request)
    {
        try {
            $id_user = 0;
            $id_exam = $request->input('id_exam');
//            echo $id_exam;die();

            $question = new Questions();
            $detail_result = new DetailResultExam();
            $results = new ResultExam();
            $result_id = $results->insertGetId([
                'id_exam' => $id_exam,
                'id_user' => $id_user,
                'date_result' => new \DateTime(),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
            $correct_answer = $request->input('answer');
            foreach ($correct_answer as $id_ques => $correct) {
                $detal_result = $detail_result->insert([
                    'id_result' => $result_id,
                    'id_ques' => $id_ques,
                    'user_correct_ques' => $correct,
                    'updated_at' => new \DateTime(),
                ]);
            }
            return redirect(route('showTestResult',['id_result' => $result_id]));
//            return view('site.default.show_result', compact('result_id', 'id_exam', 'id_user','question_1','question_2','question_3'));
        } catch (\Exception $exception) {
            $error = 1;
            return redirect('/');
        }

    }
    public function showTestResult(Request $request,$result_id)
    {
//        try {
            $id_user = 0;
            $exam = new Exam();
            $exam = $exam->select('*')
                ->join('result_exam','result_exam.id_exam','=','exam.id_exam')
                ->where('result_exam.id_result',$result_id)
                ->first();
            $id_exam = $exam->id_exam;
            $result_id  = $exam->id_result;
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
//            return redirect(route('showResult',['id_result' => $result_id]));
            return view('site.exam.show_test_result', compact( 'id_exam', 'id_user','result_id','question_1','question_2','question_3','exam'));
//        } catch (\Exception $exception) {
//            $error = 1;
//            return view('site.erorr.404');
//        }
    }

}
