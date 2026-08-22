<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Exam\CategoriesExam;
use App\Entity\User;
use App\Exam\ExamLocalJob;
use App\Exam\ExamTypeBusiness;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class ExamTypeBusinessController extends \App\Http\Controllers\Admin\AdminController
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

        $exam_model = new ExamTypeBusiness();
        $exam_locals = $exam_model->select('*')->get();
        return view('admin.exam.exam_type_business.list', compact('exam_locals'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exam.exam_type_business.add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exam_model = new ExamTypeBusiness();
        $exam_local = $exam_model->insertGetId([
            'exam_type_name'=> $request->input('exam_type_name'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('exam_type_business.index'));
    }


    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $exam_type_id )
    {

        $exam_model = new ExamTypeBusiness();
        $exam_local = $exam_model->select('*')->where('exam_type_id',$exam_type_id)->first();
        return view('admin.exam.exam_type_business.edit', compact('exam_local'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $exam_type_id)
    {
        $exam_model = new ExamTypeBusiness();
        $exam_local = $exam_model->where('exam_type_id',$exam_type_id)->update([
            'exam_type_name'=> $request->input('exam_type_name'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('exam_type_business.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $exam_type_id)
    {
        $exam_model = new ExamTypeBusiness();
        $exam_local = $exam_model->where('exam_type_id',$exam_type_id)->delete();
        return redirect(route('exam_type_business.index'));
    }
}
