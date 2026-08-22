<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\CategoriesExam;
use App\Entity\Questions;
use App\Entity\Exam;
use App\Entity\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\ResAdvisory;
use App\Entity\StarExam;
use App\Entity\TeacherStar;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;



class ResAdvisoryController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createResAdvisory(Request $request)
    {
//        try {
            $resad = new ResAdvisory();
                $resad = $resad->insert([
                    'name_res' => $request->input('name_res'),
                    'email_res' => $request->input('email_res'),
                    'phone_res' => $request->input('phone_res'),
                    'address_res' => $request->input('address_res'),
                    'message_res' => $request->input('message_res'),
                    'status_res' => $request->input('status_res'),
                    'created_at' => new \DateTime(),
                ]);
                //gui email thong bao
                MailConfigController::support($request->input('email_res'));
                $url = redirect()->back()->getTargetUrl();


                $title = \App\Entity\TypeInformation::getTitle('cam-on-dk-tu-van');

                if(isset($title)){
                    return redirect($url)->with('success_dvisory', $title);
                }
                return redirect($url)->with('success_dvisory', 'Cảm ơn bạn đã đăng kí nhận tư vấn');
//        }
//        catch (\Exception $e)
//        {
//            $url = redirect()->back()->getTargetUrl();
//            return redirect($url)->with('success_dvisory', 'Đăng kí nhận bị lỗi ! Vui lòng thử lại');
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
    public function edit($id_exam)
    {

        try{
            $this->checkLevelUser();
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
            return view('site.admin_site.exam.sua-de-thi', compact('categories_exam', 'exam', 'categories_join_exam', 'question_1','question_2','question_3'));
        }catch (\Exception $e)
        {
            Log::error('Loi');
            return redirect( route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
        }

    }
    public function update(Request $request, $exam_id)
    {
        try {
            $this->checkLevelUser();
            $user = Auth::user();
            $exam = new Exam();
            $examfind = $exam->select('*')->where('id_exam', '=', $exam_id)->first();
            //        inser vao bang exam
            $exam = $exam->where('id_exam', '=', $exam_id)
//            ->where('id_user', '=', $user->id)
                ->update([
                    'name_exam' => $request->input('name_exam'),
                    'intro_exam' => $request->input('intro_exam'),
                    'content_exam' => $request->input('content_exam'),
                    'time_exam' => $request->input('time_exam'),
                    'level_exam' => $request->input('level_exam'),
                    'status_exam' => $request->input('status_exam'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                    'image_exam' => $request->has('images') ? $request->input('images') : '',
                ]);
            //        insert bang categories_join_exam
            $category_join_exam = new CategoriesJoinExam();
            $categories = array();
            $categories = $request->input('categories');
            //xoa danh muc cua categories_join_xam
            $category_join_exam->where('id_exam', '=', $exam_id)
                ->delete();

            $id_cate = '';
//        lay ve danh sach chuoi
            foreach($categories as $cate)
            {
                $id_cate .= $cate .',';
            }
            $id_cate = rtrim($id_cate, ",");
//        chuyen chuoi thanh mang
            $id_array = explode(',',$id_cate);
//        Xoa gia tri trung trong mang
            $id_array =  array_unique($id_array);
//            echo '<pre>';
//            print_r($id_array);
//            echo '</pre>';die();

            //them mới lại danh muc cua categories_join_xam
            if (!empty($id_array)) {
                foreach ($id_array as $cate) {
                    $category_join_exam->insert([
                        'id_exam' => $exam_id,
                        'id_categories_exam' => $cate,
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }
            return redirect(route('showExam',['id_exam' =>$exam_id ]))->with('suscess', 'Sửa đề thi <span class="btnGreen btnSmall clwhite">'.$examfind['code_exam'].'</span> thành công');
        }
        catch (\Exception $e)
        {
            return redirect(route('showExam',['id_exam' =>$exam_id ]))->with('erorr', 'Sửa đề thi <span class="btnGreen btnSmall clwhite">'.$examfind['code_exam'].'</span> thất bại');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id_exam)
    {
        try {
            $this->checkLevelUser();
            $id_user = Auth::user()->id;
            $e_xam = new Exam();
            //kiem tra xem user co phai la nguoi tao không
//            neu tao thi cho xoa
            $e_xam = $e_xam->select('*')
                ->where('id_user','=',$id_user)
                ->where('id_exam','=', $id_exam)
                ->first();
//            print_r($e_xam);die();
            if($id_user == $e_xam['id_user'])
            {
                $e_xam->where('id_exam','=', $id_exam)
                    ->where('id_user','=',$id_user)
                    ->delete();
                $question = new Questions();
                $question->where('id_exam','=', $id_exam)
                    ->delete();
                return redirect(route('showExam'))->with('suscess', 'Bạn đã xóa đề thi có mã đề '.'"'.$e_xam['code_exam'].'"'.' thành công !');
            }
            else
            {
                return redirect(route('showExam'))->with('erorr', 'Xóa đê thi thất bại');
            }
        } catch (\Exception $e) {
            return redirect(route('showExam'))->with('erorr', 'Đã xảy ra lỗi trong quá trình xóa');
            Log::error('http->admin->categoryController->destroy: Lỗi xảy tra trong quá trình xóa danh mục');
        }
    }
    public function showcopyExam(Request $request , $id_exam)
    {
        try{
            $user = Auth::user();
            $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
            $exam = new Exam();
            $exam = $exam->select('*')
                ->where('id_exam', '=', $id_exam)
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
            return view('site.admin_site.exam.copy-de-thi', compact('categories_exam', 'exam', 'categories_join_exam'));
        }catch (\Exception $e)
        {
            Log::error('Loi');
            return redirect( route('showAllExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
        }
    }
    public function copyExam(Request $request)
    {
        try {
            $id_exam = $request->input('id_exam');
            $user = Auth::user();
            $exams = new Exam();
            $questions = new Questions();
            //xu ly de thi
            $exam_first = $exams->select('*')->where('id_exam', $id_exam)->first();
            $id_exam_copy = $exams->insertGetId([
                'name_exam' => $request->input('name_exam'),
                'intro_exam' => $request->input('intro_exam'),
                'content_exam' => $request->input('content_exam'),
                'time_exam' => $request->input('time_exam'),
                'level_exam' => $request->input('level_exam'),
                'status_exam' => $request->input('status_exam'),
                'id_user' => $user->id,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'image_exam' => $request->has('images') ? $request->input('images') : '',
            ]);
//            ma code
            $this->code_exam($id_exam_copy);
//            xu ly copy danh muc
            $category_join_exam = new CategoriesJoinExam();

            $categories = $request->input('categories');
            $id_cate = '';
            foreach($categories as $cate)
            {
                $id_cate .= $cate .',';
            }
            $id_cate = rtrim($id_cate, ",");
            $id_array = explode(',',$id_cate);
            $id_array =  array_unique($id_array);
            if(!empty($id_array))
            {
                foreach ($id_array as $cate) {
                    $category_join_exam->insert([
                        'id_exam' => $id_exam_copy,
                        'id_categories_exam' => $cate,
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }
            // xu ly cau hoi
            $list_questions = $questions->select('*')->where('id_exam', $id_exam)->get();
            foreach ($list_questions as $question) {
                $insert = $questions->insert([
                    'id_exam' => $id_exam_copy,
                    'type_ques' => $question->type_ques,
                    'name_ques' => $question->name_ques,
                    'show_answer_ques' => $question->show_answer_ques,
                    'answer1' => $question->answer1,
                    'answer2' => $question->answer2,
                    'answer3' => $question->answer3,
                    'answer4' => $question->answer4,
                    'correct_answer' => $question->correct_answer,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            }
            return redirect(route('showExam'))->with('suscess', 'Copy câu hỏi thành công');
        }catch (\Exception $e)
        {
            return redirect(route('showExam'))->with('error', 'Copy câu hỏi thất bại ');
        }
    }
    public function examDatatables(Request $request) {
        $e_xams = Exam::select('*')
            ->join('users', 'users.id', '=', 'exam.id_user')
            ->get();
        return Datatables::of($e_xams)
            ->addColumn('action', function($e_xams) {
                $string =  '<a href="'.route('exam.edit', ['id_exam' => $e_xams->id_exam]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('exam.destroy', ['id_exam' => $e_xams->id_exam]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('id_exam', 'id_exam desc')
            ->make(true);
    }
//    public function checkQues(Request $request)
//    {
//
//        $exams = new Exam();
//        $questions = new Questions();
//        $exams = $exams->select('*')->get();
//        foreach($exams as $exam)
//        {
//            $count = $questions->where('id_exam',$exam->id_exam)->count();
//            if($count > 0)
//            {
//                $exam = $exam->where('id_exam', '=', $exam->id_exam)
//                    ->update([
//                        'is_ques' => 1,
//                    ]);
//            }
//        }
//        return redirect('/');
//    }

}
