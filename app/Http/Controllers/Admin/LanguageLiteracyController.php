<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Experience_business;
use App\Entity\Experience_postion;
use App\Entity\LanguageLiteracy;
use App\Entity\Office_information;
use App\Entity\Software;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class LanguageLiteracyController extends AdminController
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
        return view('admin.setting.lang.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.lang.add');
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
            LanguageLiteracy::insert([
                'lang_name' => $request->input('lang_name'),
                'lang_salary' => $request->input('lang_salary'),
                'lang_give' => $request->input('lang_give'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('lang.index'));
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
    public function edit(Request $request ,$lang_id)
    {
        $exp = LanguageLiteracy::where('lang_id',$lang_id)->first();
        return view('admin.setting.lang.edit', compact('exp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang_id)
    {

        try{
            DB::beginTransaction();
            LanguageLiteracy::where('lang_id',$lang_id)->update([
                'lang_name' => $request->input('lang_name'),
                'lang_salary' => $request->input('lang_salary'),
                'lang_give' => $request->input('lang_give'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('lang.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang_id)
    {
        try{
            DB::beginTransaction();
            LanguageLiteracy::where('lang_id',$lang_id)->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
        }finally{
            return redirect(route('lang.index'));
        }
    }

    public function anyDatatable(){
        $software_list = LanguageLiteracy::select(
            'lang_id',
            'lang_name',
            'lang_salary',
            'lang_give'
        );
        return Datatables::of($software_list)
            ->addColumn('action', function ($software){
                $string = '<a href="' . route('lang.edit',['lang_id' => $software->lang_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('lang.destroy', ['lang_id' => $software->lang_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('lang_id', 'lang_id desc')
            ->make(true);
    }
}
