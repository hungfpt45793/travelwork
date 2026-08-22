<?php

namespace App\Http\Controllers\Admin;

use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TypeOfBusinessController extends AdminController
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
        return view('customers.employer_group.list');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.employer_group.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if($request->has('description')){
                $description = $request->input('description');
            }else{
                $description = "";
            }
            TypeOfBusiness::insert([
                'type_of_business_name' => $request->input('type_of_business_name'),
                'type_of_business_slug' => Ultility::createSlug($request->input('type_of_business_name')),
                'type_of_business_salary' => $request->input('type_of_business_salary'),
                'description' => $description,
                'created_at' => new\DateTime(),
                'updated_at' => new\DateTime()
            ]);
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã xảy ra lỗi trong quá trình nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('typeOfBusiness.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TypeOfBusiness $typeOfBusiness)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeOfBusiness $typeOfBusiness)
    {
        return view('customers.employer_group.edit', compact('typeOfBusiness'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeOfBusiness $typeOfBusiness)
    {
        try {
            DB::beginTransaction();
            if($request->has('description')){
                $description = $request->input('description');
            }else{
                $description = "";
            }
            $typeOfBusiness->update([
                'type_of_business_name' => $request->input('type_of_business_name'),
                'type_of_business_slug' => Ultility::createSlug($request->input('type_of_business_name')),
                'type_of_business_salary' => $request->input('type_of_business_salary'),
                'description' => $description,
                'updated_at' => new\DateTime()
            ]);
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể cập nhật dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('typeOfBusiness.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeOfBusiness $typeOfBusiness)
    {
        try {
            DB::beginTransaction();
            $typeOfBusiness->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
        } finally {
            return redirect(route('typeOfBusiness.index'));
        }
    }

    public function anyDatatable(){
        $typeOfBusinessList = TypeOfBusiness::select(
            'type_of_business_id',
            'type_of_business_name',
            'type_of_business_slug',
            'type_of_business_salary',
            'total_money',
            'recruit',
            'recruited'
        );
        return Datatables::of($typeOfBusinessList)
            ->addColumn('action', function ($typeOfBusiness){
                $string = '<a href="' . route('typeOfBusiness.edit',['type_of_business_id' => $typeOfBusiness->type_of_business_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('typeOfBusiness.destroy', ['type_of_business_id' => $typeOfBusiness->type_of_business_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('type_of_business_id', 'type_of_business_id desc')
            ->make(true);
    }
}
