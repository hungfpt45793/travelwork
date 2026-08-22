<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Experience_postion;
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

class ExperiencePosController extends AdminController
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
        return view('admin.setting.exp.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.exp.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'exp_name' => 'unique:experience_postion'
        ],[
            'exp_name.unique' => 'Phần mềm đã có. Bạn vui lòng nhập tên phần mềm khác.'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            Experience_postion::insert([
                'exp_name' => $request->input('exp_name'),
                'exp_salary' => $request->input('exp_salary'),
                'created_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('exp_pos.index'));
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
    public function edit(Request $request ,$exp_id)
    {
        $exp = Experience_postion::where('exp_id',$exp_id)->first();
        return view('admin.setting.exp.edit', compact('exp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $exp_id)
    {

        try{
            DB::beginTransaction();
            Experience_postion::where('exp_id',$exp_id)->update([
                'exp_name' => $request->input('exp_name'),
                'exp_salary' => $request->input('exp_salary'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('exp_pos.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy($exp_id)
    {
        try{
            DB::beginTransaction();
            Experience_postion::where('exp_id',$exp_id)->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
        }finally{
            return redirect(route('exp_pos.index'));
        }
    }

    public function anyDatatable(){
        $software_list = Experience_postion::select(
            'exp_id',
            'exp_name',
            'exp_salary'
        );
        return Datatables::of($software_list)
            ->addColumn('action', function ($software){
                $string = '<a href="' . route('exp_pos.edit',['exp_id' => $software->exp_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('exp_pos.destroy', ['exp_id' => $software->exp_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('exp_id', 'exp_id desc')
            ->make(true);
    }
}
