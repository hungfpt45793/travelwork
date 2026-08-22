<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Business;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class BusinessController extends AdminController
{
    protected $role;
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

        return view('admin.business.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.business.add');
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
            if($request->has('description')){
                $description = $request->input('description');
            }else{
                $description = "";
            }
            Business::insert([
                'business_type_name' => $request->input('business_type_name'),
                'business_type_slug' => Ultility::createSlug($request->input('business_type_name')),
                'business_type_salary' => $request->input('business_type_salary'),
                'description' => $description,
                'created_at' => new \DateTime(),
                'updated_at'=> new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu. Lỗi khi nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('business.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        return view('admin.business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        try{
            DB::beginTransaction();
            if($request->has('description')){
                $description = $request->input('description');
            }else{
                $description = "";
            }
            $business->update([
                'business_type_name' => $request->input('business_type_name'),
                'business_type_slug' => Ultility::createSlug($request->input('business_type_name')),
                'business_type_salary' => $request->input('business_type_salary'),
                'description' => $description,
                'updated_at'=> new \DateTime()
            ]);
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể thêm mới dữ liệu. Lỗi khi nhập dữ liệu');
            DB::rollback();
        }finally{
            return redirect(route('business.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        try{
            DB::beginTransaction();
            $business->delete();
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể xóa dữ liệu. Đã có lỗi xảy ra');
            DB::rollBack();
        }finally{
            return redirect(route('business.index'));
        }
    }

    public function anyDatatable(){
        $businessList = Business::select(
            'business_type_id',
            'business_type_name',
            'business_type_slug',
            'business_type_salary',
            'total_costs',
            'recruit',
            'recruited'
        );
        return Datatables::of($businessList)
            ->addColumn('action', function ($business){
                $string = '<a href="' . route('business.edit',['business_type_id' => $business->business_type_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('business.destroy', ['business_type_id' => $business->business_type_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('business_type_id', 'business_type_id desc')
            ->make(true);
    }
}
