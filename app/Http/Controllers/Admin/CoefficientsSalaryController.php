<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Coefficients_salary;
use App\Entity\Software;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CoefficientsSalaryController extends AdminController
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
        $coe = Coefficients_salary::select(
            'coe_id',
            'ip',
            'user_id',
            'total_salary',
            'career_category_id', //danh mục ngành nghề
            'type_of_business_id', //loại hình doanh nghiệp
            'business_type_id', //	loại hình kinh doanh
            'literacy_id', //trình dodjd học vấn
            'office_id', //	tin học văn phòng
            'exp_id', //kinh nghiệm vị trí khác
            'exp_bus_id', //	kinh nghiệm loại hình doanh nghiệp
            'software_id', //phần mềm kê toán
            'lang_id', //trình độ ngoại ngữ
            'soft_id', //kỹ năng mềm
            'cer_id', //chứng chỉ nghề nghiệp
            'work_id', //khả năng chịu áp lực
            'province_id', //thành phố
            'com_id', //cam kết gắn bó với công ty
            'created_at'
        )->orderBy('coe_id','desc')
            ->get();
        return view('admin.setting.coe.list',compact('coe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.software.add');
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
            'software_name' => 'unique:software'
        ],[
            'software_name.unique' => 'Phần mềm đã có. Bạn vui lòng nhập tên phần mềm khác.'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            Software::insert([
                'software_name' => $request->input('software_name'),
                'software_salary' => $request->input('software_salary'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('software.index'));
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
    public function edit(Software $software)
    {
        return view('admin.software.edit', compact('software'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Software $software)
    {
        $validator = Validator::make($request->all(),[
            'software_name' => Rule::unique('software')->ignore($software->software_id, 'software_id')
        ],[
            'software_name.unique' => 'Phần mềm đã có. Bạn vui lòng nhập tên phần mềm khác'
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            $software->update([
                'software_name' => $request->input('software_name'),
                'software_salary' => $request->input('software_salary'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể cập dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('software.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy(Software $software)
    {
        try{
            DB::beginTransaction();
            $software->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
        }finally{
            return redirect(route('software.index'));
        }
    }

    public function anyDatatable(){

    }
}
