<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Exam\CategoriesExam;
use App\Entity\User;
use App\Exam\ExamLocalJob;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class ExamLocalJobController extends \App\Http\Controllers\Admin\AdminController
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
        $exam_model = new ExamLocalJob();
        $exam_locals = $exam_model->select('*')->get();
        return view('admin.exam.exam_local_job.list', compact('exam_locals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exam.exam_local_job.add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exam_model = new ExamLocalJob();
        $exam_local = $exam_model->insertGetId([
            'exam_local_job'=> $request->input('exam_local_job'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('exam_local_job.index'));
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
    public function edit(Request $request, $exam_local_job_id )
    {

        $exam_model = new ExamLocalJob();
        $exam_local = $exam_model->select('*')->where('exam_local_job_id',$exam_local_job_id)->first();
        return view('admin.exam.exam_local_job.edit', compact('exam_local'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $exam_local_job_id)
    {
       $exam_model = new ExamLocalJob();
        $exam_local = $exam_model->where('exam_local_job_id',$exam_local_job_id)->update([
            'exam_local_job'=> $request->input('exam_local_job'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('exam_local_job.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $exam_local_job_id)
    {
        $exam_model = new ExamLocalJob();
        $exam_local = $exam_model->where('exam_local_job_id',$exam_local_job_id)->delete();
        return redirect(route('exam_local_job.index'));
    }
}
