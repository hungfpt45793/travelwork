<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Entity\SaleGroup;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class SaleGroupController extends AdminController
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

            view()->share('menuTop', 'sales');

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
        return view('sales.sale_group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.sale_group.add');
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
                $description = '';
            }
            SaleGroup::insert([
                'list_sales_packages_name' => $request->input('sale_group_name'),
                'description' => $description,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Lỗi khi nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('saleGroup.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SaleGroup $saleGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleGroup $saleGroup)
    {
        return view('sales.sale_group.edit', compact('saleGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleGroup $saleGroup)
    {
        try {
            DB::beginTransaction();
            if($request->has('description')){
                $description = $request->input('description');
            }else{
                $description = '';
            }
            $saleGroup->update([
                'list_sales_packages_name' => $request->input('sale_group_name'),
                'description' => $description,
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể cập nhật dữ liệu. Lỗi khi nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('saleGroup.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleGroup $saleGroup)
    {
        try {
            DB::beginTransaction();
            $saleGroup->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
        } finally {
            return redirect(route('saleGroup.index'));
        }
    }

    public function anyDatatable(){
        $saleGroups = SaleGroup::select(
            'list_sales_packages_id',
            'list_sales_packages_name',
            'quantity',
            'total_costs',
            'paid',
            'description'
        );
        return Datatables::of($saleGroups)
            ->addColumn('action', function ($saleGroup){
                $string = '<a href="' . route('saleGroup.edit',['list_sales_packages_id' => $saleGroup->list_sales_packages_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('saleGroup.destroy', ['list_sales_packages_id' => $saleGroup->list_sales_packages_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('list_sales_packages_id', 'list_sales_packages_id desc')
            ->make(true);
    }
}
