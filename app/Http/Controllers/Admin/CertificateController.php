<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Certificate;
use App\Entity\CommitCompany;
use App\Entity\Experience_business;
use App\Entity\Experience_postion;
use App\Entity\LanguageLiteracy;
use App\Entity\Office_information;
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

class CertificateController extends AdminController
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
        return view('admin.setting.cert.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.cert.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        try{
//            DB::beginTransaction();
            Certificate::insert([
                'cer_name' => $request->input('cer_name'),
                'cer_salary' => $request->input('cer_salary'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
//        }catch (\Exception $exception){
//            Error::setErrorMessage('Không thể thêm mới dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
//            DB::rollBack();
//        }finally{
            return redirect(route('cert.index'));
//        }
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
    public function edit(Request $request ,$cer_id)
    {
        $exp = Certificate::where('cer_id',$cer_id)->first();
        return view('admin.setting.cert.edit', compact('exp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cer_id)
    {

        try{
            DB::beginTransaction();
            Certificate::where('cer_id',$cer_id)->update([
                'cer_name' => $request->input('cer_name'),
                'cer_salary' => $request->input('cer_salary'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('cert.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy($cer_id)
    {
        try{
            DB::beginTransaction();
            Certificate::where('cer_id',$cer_id)->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
        }finally{
            return redirect(route('cert.index'));
        }
    }

    public function anyDatatable(){
        $software_list = Certificate::select(
            'cer_id',
            'cer_name',
            'cer_salary'
        );
        return Datatables::of($software_list)
            ->addColumn('action', function ($software){
                $string = '<a href="' . route('cert.edit',['cer_id' => $software->cer_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('cert.destroy', ['cer_id' => $software->cer_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('cer_id', 'cer_id desc')
            ->make(true);
    }
}
