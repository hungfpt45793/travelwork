<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site\Exam;



use App\Exam\CategoriesExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;


class ExamAuditions extends SiteController
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
    //danh sach de thi
    public function showExam(Request $request)
    {
        $this->checkRoleUser();
        $id = Auth::user()->id;
        $user = Auth::user();
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'code_exam',
            'name_exam',
            'intro_exam',
            'id_cate_exam',
            'time_exam'
        )
            ->leftJoin('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam');
        $exams = $exams->where('exam.id_user', '=', $id)
            ->orderBy('exam.id_exam', 'desc');
        if(!empty($request->input('id_cate_exam')))
        {

            $id_cate_exam = $request->input('id_cate_exam');
            foreach($id_cate_exam as $id=>$cate_id)
            {
                if(!empty($cate_id))
                {
                    $exams = $exams->where('categories_join_exam.id_categories_exam',$cate_id);
                }
            }
        }
        if(!empty($request->input('exam_name')))
        {
            $exam_name = $request->input('exam_name');
            $exams = $exams->where('exam.name_exam', 'like', '%'.$exam_name.'%');
        }
        $exams = $exams->distinct('exam.id_exam');
        $total = 0;
        $total = $exams->count('exam.id_exam');
        $exams = $exams->groupBy(
            'exam.id_exam',
            'code_exam',
            'name_exam',
            'intro_exam',
            'id_cate_exam',
            'time_exam'
        );

        $exams = $exams->paginate(10);
        $exams->appends(request()->query());
        return view('site.exam_admin_site.exam.lists_exam', compact('id', 'exams','user','total'));
    }
//    ngan hang de thi
    public function showAllExam(Request $request)
    {

        $this->checkRoleUser();
        $id = Auth::user()->id;
        $user = Auth::user();
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'code_exam',
            'name_exam',
            'intro_exam',
            'id_cate_exam',
            'time_exam'
        )
            ->leftJoin('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
            ->orderBy('exam.id_exam', 'desc')
            ->where('exam.bank_exam', '=', 1);
        if(!empty($request->input('id_cate_exam')))
        {

            $id_cate_exam = $request->input('id_cate_exam');
            foreach($id_cate_exam as $id=>$cate_id)
            {
                if(!empty($cate_id))
                {
                    $exams = $exams->where('categories_join_exam.id_categories_exam',$cate_id);
                }
            }
        }
        if(!empty($request->input('exam_name')))
        {
            $exam_name = $request->input('exam_name');
            $exams = $exams->where('exam.name_exam', 'like', '%'.$exam_name.'%');
        }
        $exams = $exams->distinct('exam.id_exam');
        $total = 0;
        $total = $exams->count('exam.id_exam');
        $exams = $exams->groupBy(
            'exam.id_exam',
            'code_exam',
            'name_exam',
            'intro_exam',
            'id_cate_exam',
            'time_exam'
        );

        $exams = $exams->paginate(10);
        $exams->appends(request()->query());


        return view('site.exam_admin_site.exam.lists_bank_exam', compact('id', 'exams','user','total'));

    }

    public function show_dataTable_Exam(Request $request)
    {
        $id = Auth::user()->id;
        $e_xams = Exam::select('*')
            ->where('exam.id_user', '=', $id)
            ->get();
        return Datatables::of($e_xams)
            ->addColumn('action', function ($e_xams) {
                $string = '<a href="' . route('exam.edit', ['id_exam' => $e_xams->id_exam]) . '">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="' . route('exam.destroy', ['id_exam' => $e_xams->id_exam]) . '" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('id_exam', 'id_exam desc')
            ->make(true);
    }


    public function index()
    {
        try {
            $e_xams = Exam::select('*')
                ->join('users', 'users.id', '=', 'exam.id_user')
                ->paginate(15);
        } catch (\Exception $e) {
            $categories = null;
//            Error::setErrorMessage('Hiển thị danh mục xảy ra lỗi.');
            Log::error('http->Admin->CategoryController->index: Hiển thị danh mục xảy ra lỗi');
        } finally {
            return view('admin.exam.list', compact('e_xams'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkRoleUser()
    {
        $role = Auth::user()->role;
        if ($role == 2 or $role == 3 ) {

        }else
        {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
    }

    public function create(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 0) {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
        return view('site.exam_admin_site.exam.them-moi-de-thi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        try {
        $this->checkRoleUser();
        $user = Auth::user();
        $this->validate($request, [
            'name_exam' => 'required|max:255',
            'time_exam' => 'required|min:1',
        ]);
//        validate checkradio
        $categories = \App\Exam\CategoriesExam::getCategories_exam();
        foreach ($categories as $id_validate => $cate_exam) {
            $id_validate++;
            $this->validate($request, [
                'categories' . $id_validate => 'required',
            ]);
        }
        $bank_exam = 0;
        if ($user->is_bank == 1) {
            $bank_exam = 1;
        }
        $exam = new Exam();
        $exam_id = $exam->insertGetId([
            'name_exam' => $request->input('name_exam'),
            'intro_exam' => $request->input('intro_exam'),
            'content_exam' => $request->input('content_exam'),
            'time_exam' => $request->input('time_exam'),
            'level_exam' => $request->input('level_exam'),
            'status_exam' => $request->input('status_exam'),
            'id_user' => $user->id,
            'bank_exam' => $bank_exam,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
            'image_exam' => $request->has('images') ? $request->input('images') : '',
        ]);
        $this->code_exam($exam_id);
        //        insert bang categories_join_exam
        $category_join_exam = new CategoriesJoinExam();
        $categories = array();

        $categories_exam = new CategoriesExam();

//        co danh danh muc nen if 2 lan
        if (!empty($request->input('categories1'))) {
            $categories = $request->input('categories1');
            $id_cate = '';
            foreach ($categories as $cate) {
                $id_cate .= $cate . ',';
            }
            $id_cate = rtrim($id_cate, ",");
//        chuyen chuoi thanh mang
            $id_array = explode(',', $id_cate);
//        Xoa gia tri trung trong mang
            $id_array = array_unique($id_array);
//            echo '<pre>';
//            print_r($id_array);
//            echo '</pre>';die();
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
        }
        if (!empty($request->input('categories2'))) {
            $categories = $request->input('categories2');
            $id_cate = '';
            foreach ($categories as $cate) {
                $id_cate .= $cate . ',';
            }
            $id_cate = rtrim($id_cate, ",");
//        chuyen chuoi thanh mang
            $id_array = explode(',', $id_cate);
//        Xoa gia tri trung trong mang
            $id_array = array_unique($id_array);
//            echo '<pre>';
//            print_r($id_array);
//            echo '</pre>';die();
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
        }


        return redirect(route('getAllQuestionsZero', ['id_exam' => $exam_id]))->with('suscees', 'Thêm đề thi thành công');
//        } catch (\Exception $e) {
//            return redirect(route('showExam'))->with('erorr', 'Thêm đề thi thất bại');
//        }
    }

    public function code_exam($id_exam)
    {
        $id_exam = intval($id_exam);
        $code_exam = 'MD' . ($id_exam + 100);
        Exam::where('id_exam', $id_exam)->update([
            'code_exam' => $code_exam,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id_exam)
    {

        try {
            $this->checkRoleUser();
            $user = Auth::user();
            $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
            $exam = new Exam();
            $exam = $exam->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('id_user', '=', $user->id)
                ->first();
            if (empty($exam)) {
                return redirect(route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
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
            return view('site.exam_admin_site.exam.edit', compact('categories_exam', 'exam', 'categories_join_exam', 'question_1', 'question_2', 'question_3'));
        } catch (\Exception $e) {
            Log::error('Loi');
            return redirect(route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
        }

    }

    public function update(Request $request, $exam_id)
    {
//        try {
        $this->checkRoleUser();
        $user = Auth::user();
        $exam = new Exam();
        $examfind = $exam->select('*')->where('id_exam', '=', $exam_id)->first();
        //        inser vao bang exam

        $this->validate($request, [
            'name_exam' => 'required|max:255',
            'time_exam' => 'required|min:1',
        ]);
        //        validate checkradio
        $categories = \App\Exam\CategoriesExam::getCategories_exam();
        foreach ($categories as $id_validate => $cate_exam) {
            $id_validate++;
            $this->validate($request, [
                'categories' . $id_validate => 'required',
            ]);
        }
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

        $category_join_exam->where('id_exam', '=', $exam_id)
            ->delete();

//        co danh danh muc nen if 2 lan
        if (!empty($request->input('categories1'))) {
            $categories = $request->input('categories1');
            $id_cate = '';
            foreach ($categories as $cate) {
                $id_cate .= $cate . ',';
            }
            $id_cate = rtrim($id_cate, ",");
//        chuyen chuoi thanh mang
            $id_array = explode(',', $id_cate);
//        Xoa gia tri trung trong mang
            $id_array = array_unique($id_array);
//            echo '<pre>';
//            print_r($id_array);
//            echo '</pre>';die();
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
        }
        if (!empty($request->input('categories2'))) {
            $categories = $request->input('categories2');
            $id_cate = '';
            foreach ($categories as $cate) {
                $id_cate .= $cate . ',';
            }
            $id_cate = rtrim($id_cate, ",");
//        chuyen chuoi thanh mang
            $id_array = explode(',', $id_cate);
//        Xoa gia tri trung trong mang
            $id_array = array_unique($id_array);
//            echo '<pre>';
//            print_r($id_array);
//            echo '</pre>';die();
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
        }

        return redirect(route('showExam', ['id_exam' => $exam_id]))->with('suscess', 'Sửa đề thi <span class="btnGreen btnSmall clwhite">' . $examfind['code_exam'] . '</span> thành công');
//        } catch (\Exception $e) {
//            return redirect(route('showExam', ['id_exam' => $exam_id]))->with('erorr', 'Sửa đề thi <span class="btnGreen btnSmall clwhite">' . $examfind['code_exam'] . '</span> thất bại');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_exam)
    {
        try {
            $this->checkRoleUser();
            $id_user = Auth::user()->id;
            $e_xam = new Exam();
            //kiem tra xem user co phai la nguoi tao không
//            neu tao thi cho xoa
            $e_xam = $e_xam->select('*')
                ->where('id_user', '=', $id_user)
                ->where('id_exam', '=', $id_exam)
                ->first();
//            print_r($e_xam);die();
            if ($id_user == $e_xam['id_user']) {
                $e_xam->where('id_exam', '=', $id_exam)
                    ->where('id_user', '=', $id_user)
                    ->delete();
                $question = new Questions();
                $question->where('id_exam', '=', $id_exam)
                    ->delete();
                return redirect(route('showExam'))->with('suscess', 'Bạn đã xóa đề thi có mã đề ' . '"' . $e_xam['code_exam'] . '"' . ' thành công !');
            } else {
//                echo $id_user.'--id de thi'.$e_xam['id_user'];die();
                return redirect(route('showExam'))->with('erorr', 'Xóa đề thi thất bại');
            }
        } catch (\Exception $e) {
            return redirect(route('showExam'))->with('erorr', 'Đã xảy ra lỗi trong quá trình xóa');
            Log::error('http->admin->categoryController->destroy: Lỗi xảy tra trong quá trình xóa danh mục');
        }
    }

    public function showcopyExam(Request $request, $id_exam)
    {
        try {
            $user = Auth::user();
            $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
            $exam = new Exam();
            $exam = $exam->select('*')
                ->where('id_exam', '=', $id_exam)
                ->first();
            if (empty($exam)) {
                return redirect(route('showExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
            }
            $categories_join_exams = new CategoriesJoinExam();
            $categories_join_exams = $categories_join_exams->select('*')
                ->where('id_exam', '=', $id_exam)
                ->get();
            $categories_join_exam = array();
            foreach ($categories_join_exams as $cate) {
                $categories_join_exam[] = $cate->id_categories_exam;
            }
            return view('site.exam_admin_site.exam.copy-de-thi', compact('categories_exam', 'exam', 'categories_join_exam'));
        } catch (\Exception $e) {
            Log::error('Loi');
            return redirect(route('showAllExam'))->with('erorr', 'Lỗi không tìm thấy được đề thi');
        }
    }

    public function copyExam(Request $request)
    {
        try {
            $id_exam = $request->input('id_exam');
            $user = Auth::user();
            $this->validate($request, [
                'name_exam' => 'required|max:255',
                'time_exam' => 'required|min:1',
                'categories' => 'required',
            ]);
            $exams = new Exam();
            $questions = new Questions();
            $bank_exam = 0;
            if ($user->is_bank == 1) {
                $bank_exam = 1;
            }
            //xu ly de thi
            $exam_first = $exams->select('*')->where('id_exam', $id_exam)->first();
            $id_exam_copy = $exams->insertGetId([
                'name_exam' => $request->input('name_exam'),
                'intro_exam' => $request->input('intro_exam'),
                'time_exam' => $request->input('time_exam'),
                'level_exam' => $request->input('level_exam'),
                'status_exam' => $request->input('status_exam'),
                'content_exam' => $request->input('content_exam'),
                'id_user' => $user->id,
                'bank_exam' => $bank_exam,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'image_exam' => $request->has('images') ? $request->input('images') : '',
            ]);
//            ma code
            $this->code_exam($id_exam_copy);
//            xu ly copy danh muc
            $category_join_exam = new CategoriesJoinExam();

            if (!empty($request->input('categories'))) {
                $categories = $request->input('categories');
                $id_cate = '';
                foreach ($categories as $cate) {
                    $id_cate .= $cate . ',';
                }
                $id_cate = rtrim($id_cate, ",");
                $id_array = explode(',', $id_cate);
                $id_array = array_unique($id_array);
                if (!empty($id_array)) {
                    foreach ($id_array as $cate) {
                        $category_join_exam->insert([
                            'id_exam' => $id_exam_copy,
                            'id_categories_exam' => $cate,
                            'created_at' => new \DateTime(),
                            'updated_at' => new \DateTime(),
                        ]);
                    }
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
            return redirect(route('showExam'))->with('suscess', 'Copy đề thi thành công');
        } catch (\Exception $e) {
            return redirect(route('showExam'))->with('error', 'Copy đề thi thất bại ');
        }
    }


    public function examDatatables(Request $request)
    {
        $e_xams = Exam::select('*')
            ->join('users', 'users.id', '=', 'exam.id_user')
            ->get();
        return Datatables::of($e_xams)
            ->addColumn('action', function ($e_xams) {
                $string = '<a href="' . route('exam.edit', ['id_exam' => $e_xams->id_exam]) . '">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="' . route('exam.destroy', ['id_exam' => $e_xams->id_exam]) . '" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('id_exam', 'id_exam desc')
            ->make(true);
    }

    public function searchExamAjax(Request $request)
    {
        $id_cate_exam = $_GET['selectval'];
        if (empty($id_cate_exam)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $user = Auth::user();
        $id_user = $user->id;
        $exams = new Exam();
        $listexam = $exams->select('*')
            //where trang thai public hoac prive cua de thi
            ->join('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
//            ->join('contacts', 'users.id', '=', 'contacts.user_id')
//            ->where('exam.bank_exam', '=', 1)
            ->where('exam.id_user', '=', $id_user)
            ->where('categories_join_exam.id_categories_exam', '=', $id_cate_exam)
            ->distinct()
            ->get();

        return response([
            'status' => 200,
            'custommer' => $listexam
        ])->header('Content-Type', 'text/plain');
    }

    public function searchExamBankAjax(Request $request)
    {
        $value_session = $request->session()->get('login');
        if (empty($value_session)) {
            return redirect(URL::to('/'));
        }
        $ma_kh = $request->input('ma_kh');

        if (empty($ma_kh)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $custommer = new Customer();
        $custommer = $custommer->select('*')
            ->where('ma_kh', 'like', '%' . $ma_kh . '%')
//                    ->distinct('ten_kh')
            ->limit(15)
            ->orderBy('id_kh', 'desc')
            ->offset(0)
            ->get();
        return response([
            'status' => 200,
            'custommer' => $custommer
        ])->header('Content-Type', 'text/plain');
    }
    public function ajaxGetAllExamDatatables(Request $request)
    {
        $user = Auth::user();
        $exams = Exam::select('*')
            ->join('users', 'users.id', '=', 'exam.id_user')
            ->where('exam.id_user', $user->id)
            ->where('bank_exam', 0)
            ->get();
        return Datatables::of($exams)

            ->addColumn('action', function ($exams) {
                $string = '<a href="' . route('site_exam.edit', ['id_exam' => $exams->id_exam]) . '" class="btn btn-primary btnSmall mgBottom5" title="Sửa đề thi " data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>';
                $string .= '<a  href="' . route('getAllQuestionsZero', ['id_exam' => $exams->id_exam]) . '" class="btn btnGreen  btnSmall mgBottom5"
                                         title="Sửa câu hỏi" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>';
                $string .= ' <a  href="' . route('showcopyExam', ['id_exam' => $exams->id_exam]) . '" class="btn btn-info  btnSmall mgBottom5"
                                         title="Copy đề thi" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </a>';
                $string .= '<a  href="' . route('site_exam.destroy', ['id_exam' => $exams->id_exam]) . '" class="btn btn-danger btnDelete btnSmall"
                                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);" title="Xóa đề thi" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>';
                return $string;
            })
            ->orderColumn('id_exam', 'id_exam desc')
            ->make(true);
    }

    public function ajaxBankExamDatatables(Request $request)
    {
        $user = Auth::user();
        $exams = Exam::select('*')
            ->join('users', 'users.id', '=', 'exam.id_user')
            ->where('bank_exam', 1)
            ->get();
        return Datatables::of($exams)
            ->addColumn('action', function ($exams) {
                $string = '<a  href="' . route('getAllQuestionsZero', ['id_exam' => $exams->id_exam]) . '" class="btn btnGreen  btnSmall mgBottom5"
                                         title="Sửa câu hỏi" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>';
                $string .= ' <a  href="' . route('showcopyExam', ['id_exam' => $exams->id_exam]) . '" class="btn btn-info  btnSmall mgBottom5"
                                         title="Copy đề thi" data-toggle="tooltip" data-placement="bottom">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
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
