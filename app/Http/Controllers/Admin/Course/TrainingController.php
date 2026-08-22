<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_join_formality;
use App\Course\Course_tag;
use App\Course\Course_tag_id;
use App\Course\Courses;
use App\Entity\Learn_training_content;
use App\Entity\Teacher;
use App\Entity\Training;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class TrainingController extends AdminController
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list_training = Training::select('*')->paginate(20);
        $list_training->appends(request()->query());
        return view('admin.course.training.list', compact('list_training'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_course = Courses::where('course_status',1)->get();
        return view('admin.course.training.add',compact('list_course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function validateCourse($request)
    {
        $validation = Validator::make($request->all(), [
            'trai_title' => 'required'
        ], [
            'trai_title.required' => 'Tiêu để không được để trống'
        ]);
        return $validation;
    }



    public function store(Request $request)
    {
        $validation = $this->validateCourse($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('error', 'Đăng ký nội dung lỗi !')
                ->withInput();
        }
//        try {
        $courses_model = new Training();
        $insert_id = $courses_model->insertGetId([
            'trai_title' => $request->input('trai_title'),
            'course_id' => !empty($request->input('course_id')) ? $request->input('course_id') : 0,
            'created_at' => new \DateTime()
        ]);

        return redirect('admin/training')->with('success', 'Thêm thành công');
//        } catch (\Exception $exception) {
//            return redirect('admin/category_course')->with('error', 'Thên danh mục thất bại');
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($trai_id)
    {
        $list_course = Courses::where('course_status',1)->get();
        $training = new Training();
        $training = $training->where('trai_id', $trai_id)
            ->first();
        return view('admin.course.training.edit', compact('training','list_course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $trai_id)
    {
        $courses_model = new Training();
        $update_id = $courses_model->where('trai_id',$trai_id)->update([
            'trai_title' => $request->input('trai_title'),
            'course_id' => !empty($request->input('course_id')) ? $request->input('course_id') : 0,
            'updated_at' => new \DateTime()
        ]);
        return redirect('admin/training')->with('success', 'Cập nhật thành công');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($trai_id)
    {
        try {
            $courses_model = new Training();
            $update_id = $courses_model->where('trai_id',$trai_id)->delete();
            return redirect('admin/training')->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect('admin/training')->with('error', 'Xóa thất bại');
        }
    }
}
