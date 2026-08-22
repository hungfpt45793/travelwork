<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Certificate;
use App\Entity\CommitCompany;
use App\Entity\Experience_business;
use App\Entity\Experience_postion;
use App\Entity\LanguageLiteracy;
use App\Entity\Office_information;
use App\Entity\SoftSkills;
use App\Entity\Software;
use App\Entity\User;
use App\Entity\WorkPressure;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SoftSkillsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'setting');

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
        return view('admin.setting.soft.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.soft.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            SoftSkills::insert([
                'soft_name' => $request->input('soft_name'),
                'soft_salary' => $request->input('soft_salary'),
                'soft_give' => $request->input('soft_give'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('soft.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function show(Software $software)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$soft_id)
    {
        $exp = SoftSkills::where('soft_id',$soft_id)->first();
        return view('admin.setting.soft.edit', compact('exp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $soft_id)
    {

        try{
            DB::beginTransaction();
            SoftSkills::where('soft_id',$soft_id)->update([
                'soft_name' => $request->input('soft_name'),
                'soft_salary' => $request->input('soft_salary'),
                'soft_give' => $request->input('soft_give'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('soft.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy($soft_id)
    {
        try{
            DB::beginTransaction();
            SoftSkills::where('soft_id',$soft_id)->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
        }finally{
            return redirect(route('soft.index'));
        }
    }

    public function anyDatatable(){
        $software_list = SoftSkills::select(
            'soft_id',
            'soft_name',
            'soft_salary',
            'soft_give'
        );
        return Datatables::of($software_list)
            ->addColumn('action', function ($software){
                $string = '<a href="' . route('soft.edit',['soft_id' => $software->soft_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('soft.destroy', ['soft_id' => $software->soft_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('soft_id', 'soft_id desc')
            ->make(true);
    }
}
