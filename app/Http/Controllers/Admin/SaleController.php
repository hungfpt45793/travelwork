<?php

namespace App\Http\Controllers\Admin;

use App\Entity\NoteSales;
use App\Entity\Sale;
use App\Entity\User;
use App\Entity\SaleGroup;
use App\Entity\SalePackageSaleGroup;
use App\Entity\Employer;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class SaleController extends AdminController
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
        return view('sales.sale.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $saleGroups = SaleGroup::get();
        $employers = Employer::get();
        $users = User::where('role', 3)->get();
        return view('sales.sale.add', compact('saleGroups', 'employers', 'users'));
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
            'price' => 'numeric',
            'paid' => 'numeric',
            'recruit_number' => 'numeric',
            'province' => 'numeric | min:1',
            'district' => 'numeric | min:1',
            'employer_id' => 'numeric | min:1',
            'user_id' => 'numeric | min:1'
        ],[
            'price.numeric' => 'Bạn phải nhập giá là một số.',
            'paid.numeric' => 'Bạn phải nhập số tiền thanh toán là một số.',
            'recruit_number.numeric' => 'Bạn phải nhập số lượng cần tuyển là một số.',
            'province.min' => 'Bạn phải chọn tỉnh/ thành phố.',
            'district.min' => 'Bạn phải chọn quận/ huyện.',
            'employer_id.min' => 'Bạn phải chọn nhà tuyển dụng.',
            'user_id.min' => 'Bạn phải chọn nhân viên.'
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $salePackageId = Sale::insertGetId([
                'sale_package_name' => $request->input('sale_package_name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'price' => $request->input('price'),
                'recruit_number' => $request->input('recruit_number'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'contract_signing_date' => $request->input('contract_signing_date'),
                'paid' => $request->has('paid') ? $request->input('paid') : 0,
                'discount' => $request->has('discount') ? $request->input('discount') : '',
                'affiliate_id' => $request->has('affiliate_id') ? $request->input('affiliate_id') : null,
                'employer_id' => $request->input('employer_id'),
                'user_id' => $request->input('user_id'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

            if($request->has('idNote')){
                NoteSales::where('note_sale_id', $request->input('idNote'))
                    ->update([
                       'sale_package_id' => $salePackageId
                    ]);
            }

            if ($request->has('list_sales_packages')) {
                foreach($request->input('list_sales_packages') as $list_sales_package) {
                    SalePackageSaleGroup::insert([
                        'sale_package_id' => $salePackageId,
                        'list_sales_packages_id' => $list_sales_package,
                        'total_costs'=> $request->input('price'),
                        'paid'=>$request->input('paid'),
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime()
                    ]);
                }
            }
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu : Lỗi khi nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('sale.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $saleGroups = SaleGroup::get();
        $employers = Employer::get();
        $users = User::where('role', 3)->get();
        return view('sales.sale.edit', compact('sale', 'saleGroups', 'employers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $validator = Validator::make($request->all(),[
            'price' => 'numeric',
            'paid' => 'numeric',
            'recruit_number' => 'numeric',
            'province' => 'numeric | min:1',
            'district' => 'numeric | min:1',
            'employer_id' => 'numeric | min:1',
            'user_id' => 'numeric | min:1'
        ],[
            'price.numeric' => 'Bạn phải nhập giá là một số.',
            'paid.numeric' => 'Bạn phải nhập số tiền thanh toán là một số.',
            'recruit_number.numeric' => 'Bạn phải nhập số lượng cần tuyển là một số.',
            'province.min' => 'Bạn phải chọn tỉnh/ thành phố.',
            'district.min' => 'Bạn phải chọn quận/ huyện.',
            'employer_id.min' => 'Bạn phải chọn nhà tuyển dụng.',
            'user_id.min' => 'Bạn phải chọn nhân viên.'
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $sale->update([
                'sale_package_name' => $request->input('sale_package_name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'price' => $request->input('price'),
                'recruit_number' => $request->input('recruit_number'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'contract_signing_date' => $request->input('contract_signing_date'),
                'paid' => $request->has('paid') ? $request->input('paid') : 0,
                'discount' => $request->has('discount') ? $request->input('discount') : '',
                'affiliate_id' => $request->has('affiliate_id') ? $request->input('affiliate_id') : null,
                'employer_id' => $request->input('employer_id'),
                'user_id' => $request->input('user_id'),
                'updated_at' => new \DateTime()
            ]);

            if ($request->has('list_sales_packages')) {
                SalePackageSaleGroup::where('sale_package_id', $sale->sale_package_id)->delete();
                foreach($request->input('list_sales_packages') as $list_sales_package) {
                    SalePackageSaleGroup::insert([
                            'sale_package_id' => $sale->sale_package_id,
                            'list_sales_packages_id' => $list_sales_package,
                            'total_costs'=> $request->input('price'),
                            'paid'=>$request->input('paid'),
                            'created_at' => new \DateTime(),
                            'updated_at' => new \DateTime()
                        ]);
                }
            }

            if($request->has('idNote')){
                NoteSales::where('note_sale_id', $request->input('idNote'))
                    ->update([
                        'sale_package_id' => $sale->sale_package_id
                    ]);
            }
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể cập nhật dữ liệu . Đã xảy ra lỗi khi nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('sale.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::beginTransaction();
            $sale->delete();
            SalePackageSaleGroup::where('sale_package_id', $sale->sale_package_id)->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã Có lỗi xảy ra");
            DB::rollBack();
        } finally {
            return redirect(route('sale.index'));
        }
    }

    public function anyDatatable(){
        $sales = Sale::join('employer','employer.employer_id','=','sale_package.employer_id')
            ->join('users','users.id','=','sale_package.user_id')
        ->select(
            'sale_package.sale_package_id',
            'sale_package.sale_package_name',
            'sale_package.created_at',
            'employer.enterprise_name',
            'users.name',
            'sale_package.recruit_number',
            'sale_package.price',
            'sale_package.paid',
            'sale_package.recruited',
            'sale_package.status',
            'sale_package.description',
            'sale_package.discount'
        );

        return Datatables::of($sales)
            ->addColumn('action', function ($sale){
                $string = '<a href="' . route('sale.edit',['sale_package_id' => $sale->sale_package_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('sale.destroy', ['sale_package_id' => $sale->sale_package_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('sale_package_id', 'sale_package_id desc')
            ->make(true);
    }

    public function note(Request $request){
        if($request->has('content')){
            $idNote = NoteSales::insertGetId([
                'note' => $request->input('content'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $string = '<p>- ' . $request->input('content')  . ' .</p>
                        <input type="hidden" name="idNote" value=" '. $idNote .'">';
            echo $string;
        }
    }
}
