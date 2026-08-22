<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Age;
use App\Entity\Combo_advise;
use App\Entity\Salary;
use App\Entity\Teacher_schools;
use App\Entity\User;
use App\Exam\Detail_result_school;
use App\Exam\Exam_school;
use App\Exam\Exam_school_question_school;
use App\Exam\Questions_school;
use App\Exam\Result_school;
use App\Exam\Room_school;
use App\Exam\Student_school;
use App\Ultility\Error;
use Google\Service\AdMob\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class Combo_adviseController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'teacher_school');
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

        $list_combo = Combo_advise::select('*')->get();
        return view('admin.school.combo_advise.list', compact('list_combo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school.combo_advise.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $combo_id = Combo_advise::insertGetId([
            'user_id' => Auth::user()->id,
            'combo_title' => $request->input('combo_title'),
            'combo_price' =>str_replace(".","",$request->input('combo_price')),
            'combom_des' => $request->input('combom_des'),
            'created_at' => new \DateTime()
        ]);
        return redirect(route('combo_advise.index'))->with('success', 'Thêm mới gói thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function edit($combo_ad_id)
    {
        $combo = Combo_advise::where('combo_ad_id', $combo_ad_id)->first();
        return view('admin.school.combo_advise.edit', compact('combo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $combo_ad_id)
    {
        $combo_id_update = Combo_advise::where('combo_ad_id', $combo_ad_id)->update([
            'user_id' => Auth::user()->id,
            'combo_title' => $request->input('combo_title'),
            'combo_price' =>str_replace(".","",$request->input('combo_price')),
            'combom_des' => $request->input('combom_des'),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('combo_advise.index'))->with('success', 'Cập nhật gói thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($combo_ad_id)
    {
        $combo_id_delete = Combo_advise::where('combo_ad_id', $combo_ad_id)
            ->delete();
        return redirect(route('combo_advise.index'))->with('success', 'Xóa gói thành công');
    }

}
