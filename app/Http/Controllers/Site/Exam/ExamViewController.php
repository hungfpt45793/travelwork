<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site\Exam;


use App\Entity\Career;
use App\Entity\Category;
use App\Entity\TypeOfBusiness;
use App\Exam\CategoriesExam;
use App\Exam\CommentExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\ResultExam;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;


class ExamViewController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'exam');
    }

    public function getAllExam(Request $request)
    {
        try {
            $exams = new Exam();
            $exams = $exams->select(
                'exam.id_exam',
                'code_exam',
                'slug_exam',
                'name_exam',
                'intro_exam',
                'id_cate_exam',
                'time_exam',
                'view_exam',
                'status_exam',
                'exam_type_id',
                'exam_local_job_id'
            )
                ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
                ->where('exam.bank_exam', '=', 1);
            $exams = $exams->distinct('exam.id_exam');
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
                'view_exam',
                'status_exam',
                'exam_type_id',
                'exam_local_job_id'
            );

            $exams = $exams->paginate(20);
            $exams->appends(request()->query());
            $user = auth()->user();
            return view('site.exam.category_exam_new', compact('exams', 'user', 'total'));
        } catch (\Exception $e) {
            return redirect('/')->with('errorExam', 'Không tìm thấy đề thi');
        }
    }

//    hien thi de thi

    public function submit_category_Exam(Request $request)
    {
//        $user = auth()->user();
//        $career = 'de-thi-ke-toan';
//        if (!empty($request->input('type_of_business_id'))) {
//            $career .= '-cho-' . $request->input('type_of_business_id');
//        }
//        if (!empty($request->input('career_category_id'))) {
//            $career .= '-voi-vi-tri-' . $request->input('career_category_id');
//        }
//        $type_of_business = TypeOfBusiness::select('*')
//            ->where('type_of_business_slug', $request->input('type_of_business_id'))
//            ->first();
//        $career_category = Career::select('*')
//            ->where('career_category_slug', $request->input('career_category_id'))
//            ->first();
//
//        $career .= '?';
//        if (!empty($request->input('type_of_business_id'))) {
//            $career .= '&t=' . $type_of_business['type_of_business_id'];
//        }
//        if (!empty($request->input('career_category_id'))) {
//            $career .= '&c=' . $career_category['career_category_id'];
//        }
//        if (!empty($request->input('word'))) {
//            $career .= '&w=' . $request->input('word');
//        }
//        return redirect(route('search_category_Exam', ['slug' => $career]));


        $user = auth()->user();
        $career = 'de-thi-ke-toan';
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business = TypeOfBusiness::select('*')
                ->orWhere('type_of_business_id', $request->input('type_of_business_id'))
                ->first();
            $career .= '-cho-' . $type_of_business->type_of_business_slug;
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category = Career::select('*')
                ->orWhere('career_category_id', $request->input('career_category_id'))
                ->first();
            $career .= '-voi-vi-tri-' . $career_category->career_category_slug;
        }
        $career .= '?';
        if (!empty($request->input('type_of_business_id'))) {
            $career .= '&t=' . $type_of_business['type_of_business_id'];
        }
        if (!empty($request->input('career_category_id'))) {
            $career .= '&c=' . $career_category['career_category_id'];
        }
        if (!empty($request->input('word'))) {
            $career .= '&w=' . $request->input('word');
        }
        return redirect(route('search_category_Exam', ['slug' => $career]));
    }

    public function search_category_Exam(Request $request, $slug)
    {
        try {
            $exams = new Exam();
            $exams = $exams->select(
                'exam.id_exam',
                'code_exam',
                'slug_exam',
                'name_exam',
                'intro_exam',
                'id_cate_exam',
                'time_exam',
                'view_exam',
                'status_exam',
                'exam_type_id',
                'exam_local_job_id'
            )
                ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
                ->where('exam.bank_exam', '=', 1);

            if (!empty($request->input('t'))) {

                $exam_type_id = $request->input('t');
                $exams = $exams->orWhere('exam.exam_type_id', $exam_type_id);
            }
            if (!empty($request->input('c'))) {

                $exam_local_job_id = $request->input('c');
                $exams = $exams->orWhere('exam.exam_local_job_id', $exam_local_job_id);
            }
            if (!empty($request->input('w'))) {
                $exam_name = $request->input('w');
                $exams = $exams->orWhere('exam.name_exam', 'like', '%' . $exam_name . '%');
            }
            $exams = $exams->distinct('exam.id_exam');
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
                'view_exam',
                'status_exam',
                'exam_type_id',
                'exam_local_job_id'
            );

            $exams = $exams->paginate(20);
            $exams->appends(request()->query());
            $user = auth()->user();
            return view('site.exam.search_category_exam_new', compact('exams', 'user', 'total'));
        } catch (\Exception $e) {
            return redirect('/')->with('errorExam', 'Không tìm thấy đề thi');
        }
    }


    public function getExam(Request $request, $slug_exam)
    {
        $exams = new Exam();
        $exam = $exams->select('*')
            //where trang thai public hoac prive cua de thi
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.slug_exam', '=', $slug_exam)
            ->first();
        if(empty($exam))
        {
            return redirect(route('home'));
        }
        $view_exam = 1;
        if (!empty($exam)) {
            $view_exam = intval($exam->view_exam) + 1;
        }
        $update = $exams->where('slug_exam', '=', $slug_exam)->update([
            'view_exam' => $view_exam
        ]);

        $categories_exams = New CategoriesExam();
        $categories_exams = $categories_exams->select('*')
            ->join('categories_join_exam', 'categories_join_exam.id_categories_exam', '=', 'categories_exam.id_cate_exam')
            ->where('categories_join_exam.id_exam', '=', $exam->id_exam)
            ->get();

//        $conments = new CommentExam();
//        $conments = $conments->select('*')->where('id_exam', $exam->id_exam)->get();

//        return view('site.exam.exam', compact('exam', 'categories_exams', 'conments'));
        return view('site.exam.exam_new', compact('exam', 'categories_exams'));
    }

    //hien thi cau hoi
    public function getQuestion(Request $request, $slug_exam)
    {
//        echo Auth::user()->role;die();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!Auth::check() || Auth::user()->role != 1) {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để làm bài thi');
        }
        $exam = new Exam();
        $exam = $exam->select('*')
//            ->join('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
//            ->join('categories_exam','categories_exam.id_cate_exam','=','categories_join_exam.id_categories_exam')
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.slug_exam', '=', $slug_exam)
            ->first();
        if (empty($exam)) {
            return redirect()->route('getAllExam')->with(
                'errorExam',
                'Đề thi không tồn tại hoặc chưa được công khai'
            );
        }
        $categories_exams = new CategoriesExam();
        $categories_exams = $categories_exams->select('*')
            ->join('categories_join_exam', 'categories_join_exam.id_categories_exam', '=', 'categories_exam.id_cate_exam')
            ->where('categories_join_exam.id_exam', '=', $exam->id_exam)
            ->get();

        $question = new Questions();
        $questions = $question->select('*')
            ->where('id_exam', '=', $exam->id_exam)
//            ->groupBy('')
            ->orderBy('type_ques', 'asc')
            ->get();
        $countQuestion = $question->select('*')
            ->where('id_exam', '=', $exam->id_exam)
            ->count();
        if ($countQuestion <= 0) {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('errorQuestion', 'Đề thi này chưa được tạo câu hỏi');
        }
        $result_exam_model = new ResultExam();
        $result_exam = $result_exam_model->select('*')
            ->where('id_exam', $exam->id_exam)
            ->where('id_user', Auth::user()->id)
            ->first();
        if (!empty($result_exam)) {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('errorExam', 'Bạn đã thi đề thi này rồi');
        }

        return view('site.exam.show_question', compact('exam', 'categories_exams', 'questions', 'countQuestion'));
    }
//    public function searchExam(Request $request)
//    {
//        $word = $request->input('word');
//        try {
//            $exams = new Exam();
//            $exams = $exams->select('*')
//                ->where('name_exam', 'like', '%'.$word.'%')
//                ->orWhere('code_exam', 'like', '%'.$word.'%')
//                ->where('exam.bank_exam', '=', 1)
//                ->orderBy('exam.id_exam','desc')
//                ->paginate(10);
//            $exams->appends(request()->query());
//            return view('site.exam.search_exam', compact('exams'));
//        }catch (\Exception $e)
//        {
//            return redirect('/');
//        }
//
//    }

}
