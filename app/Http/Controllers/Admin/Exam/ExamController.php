<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Teacher;
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
use Illuminate\Support\Facades\DB;

class ExamController extends \App\Http\Controllers\Admin\AdminController
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
        try {
            $e_xams = Exam::select('*')
                ->join('users', 'users.id', '=', 'exam.id_user')
                ->orderByDesc('exam.id_exam')
                ->paginate(15);
        } catch (\Exception $e) {
            $categories = null;
//            Error::setErrorMessage('Hiển thị danh mục xảy ra lỗi.');
            Log::error('http->Admin->CategoryController->index: Hiển thị danh mục xảy ra lỗi');
        } finally {
            return view('admin.exam.exam.list', compact('e_xams'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.exam.exam.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_exam' => 'required|max:255',
            'time_exam' => 'required|min:1',
        ]);
        try {
            $user = Auth::user();
            $exam = new Exam();
            $exam_id = $exam->insertGetId([
                'name_exam' => $request->input('name_exam'),
                'image_exam' => $request->input('image_exam'),
                'intro_exam' => $request->input('intro_exam'),
                'content_exam' => $request->input('content_exam'),
                'time_exam' => $request->input('time_exam'),
                'level_exam' => $request->input('level_exam'),
                'status_exam' => $request->input('status_exam'),
                'bank_exam' => $request->input('bank_exam'),
                'exam_type_id' => $request->input('exam_type_id'),
                'exam_local_job_id' => $request->input('exam_local_job_id'),
                'id_user' => $user->id,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
//            update code_exam
            $this->code_exam($exam_id);

            //tao slug cho de thi

            $slug = $request->input('slug_exam');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('name_exam'));
            }
            $examSlug = Exam::where('slug_exam', $slug)
                ->where('id_exam', '!=', $exam_id)
                ->first();
            if (empty($examSlug)) {
                $exam->where('id_exam', $exam_id)
                    ->update([
                        'slug_exam' => $slug
                    ]);
            } else {
                $exam->where('id_exam', $exam_id)
                    ->update([
                        'slug_exam' => $slug . '-' . $exam_id
                    ]);
            }
            return redirect(route('getQuestionZero', ['id_exam' => $exam_id]))->with('suscees', 'Thêm đề thi thành công');
        } catch (\Exception $e) {
            return redirect(route('exam.create'))->with('erorr', 'Thêm đề thi thất bại');
        }
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
//        try{
        $user = Auth::user();
        $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
        $e_xam = new Exam();
        $e_xam = $e_xam->select('*')
            ->where('id_exam', '=', $id_exam)
//            ->where('id_user', '=', $user->id) quan trị không cân phân biệt
            ->first();
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


        return view('admin.exam.exam.edit', compact('categories_exam', 'e_xam', 'categories_join_exam', 'question_1', 'question_2', 'question_3'));
//        }catch (\Exception $e)
//        {
//            Log::error('Loi');
//            return redirect('admin/categories-exam')->with('error_edit_delete', 'Lỗi không cập nhật được sản phẩm');
//        }

    }

    public function update(Request $request, $exam_id)
    {
        try {
            $user = Auth::user();
            $exam = new Exam();
            //        inser vao bang exam
            $exam = $exam->where('id_exam', '=', $exam_id)
//            ->where('id_user', '=', $user->id)
                ->update([
                    'name_exam' => $request->input('name_exam'),
                    'image_exam' => $request->input('image_exam'),
                    'intro_exam' => $request->input('intro_exam'),
                    'content_exam' => $request->input('content_exam'),
                    'time_exam' => $request->input('time_exam'),
                    'level_exam' => $request->input('level_exam'),
                    'status_exam' => $request->input('status_exam'),
                    'bank_exam' => $request->input('bank_exam'),
                    'exam_type_id' => $request->input('exam_type_id'),
                    'exam_local_job_id' => $request->input('exam_local_job_id'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            //tao slug cho de thi
            $slug = $request->input('slug_exam');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('name_exam'));
            }
            $examSlug = Exam::where('slug_exam', $slug)
                ->where('id_exam', '!=', $exam_id)
                ->first();
            if (empty($examSlug)) {
                Exam::where('id_exam', $exam_id)
                    ->update([
                        'slug_exam' => $slug
                    ]);
            } else {
                Exam::where('id_exam', $exam_id)
                    ->update([
                        'slug_exam' => $slug . '-' . $exam_id
                    ]);
            }
            //        insert bang categories_join_exam
            return redirect(route('exam.index'))->with('suscees', 'Sửa đề thi thành công');
        } catch (\Exception $e) {
            return redirect(route('exam.index'))->with('error', 'Sửa đề thi thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_exam)
    {
        try {
            $e_xam = new Exam();
            $e_xam->where('id_exam', '=', $id_exam)
                ->delete();
            $question = new Questions();
            $question->where('id_exam', '=', $id_exam)
                ->delete();
            return redirect('admin/exam')->with('delete', 'thanh cong');
        } catch (\Exception $e) {
            return redirect('admin/exam')->with('error_delete', 'thất bại');
            Log::error('http->admin->categoryController->destroy: Lỗi xảy tra trong quá trình xóa danh mục');
        }
    }

    public function examDatatables(Request $request)
    {
        $e_xams = Exam::select('*')
            ->leftJoin('users', 'users.id', '=', 'exam.id_user')
            ->get();
        return Datatables::of($e_xams)
            ->addColumn('action', function ($e_xams) {
                $string = '<a href="' . route('exam.edit', ['id_exam' => $e_xams->id_exam]) . '" title="Sửa đề thi" >
                           <button class="btn btn-primary" style="margin-bottom: 3px;display: inline-block"><i class="fa fa-pencil" aria-hidden="true" ></i></button>
                       </a>';
                $string .= '<a href="' . route('getQuestionZero', ['id_exam' => $e_xams->id_exam]) . '" title="Xem câu hỏi">
                           <button class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                       </a>';
//                $string .=  '<a href="'.route('getQuestionZero', ['id_exam' => $e_xams->id_exam]).'">
//                           <button class="btn btn-primary" style="margin-bottom: 3px;display: inline-block"><i class="fa fa-clone" aria-hidden="true"></i></button>
//                       </a>';
//
                $string .= '<a  href="' . route('exam.destroy', ['id_exam' => $e_xams->id_exam]) . '" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);" title="Xóa đề thi">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('id_exam', 'id_exam desc')
            ->make(true);
    }

    public function delete_exam($id_exam)
    {
        $user_id = Exam::where('id_exam', $id_exam)->value('id_user');

        $list_exam = Exam::where('id_user', $user_id)->get();
        foreach ($list_exam as $exam) {
            $delete = Questions::where('id_exam', $exam->id_exam)->delete();
            $delete_exam = Exam::where('id_exam', $exam->id_exam)->delete();
        }
        //xoa usser va liwn quan
        $user = User::where('id', $user_id)->first();
        if(!empty($user))
        {
            if ($user->role == 1) {
                $delete = Employee::where('user_id', $user_id)->delete();
                $delete = Employee::withTrashed()->where('user_id', $user_id)->delete();
                //xoa vinh vien
            }
            if ($user->role == 2) {
                $delete = Employer::where('user_id', $user_id)->delete();
                $delete = Employer::withTrashed()->where('user_id', $user_id)->delete();
                //xoa vinh vien
            }
            if ($user->role == 3) {
                $delete = Teacher::where('user_id', $user_id)->delete();
                $delete = Teacher::withTrashed()->where('user_id', $user_id)->delete();
                //xoa vinh vien
            }
            $forceDelete = User::withTrashed()
                ->where('id', $user_id)
                ->forceDelete();
        }
        echo 1;die();

    }

}
