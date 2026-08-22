<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee_intro_employer;
use App\Entity\User;
use App\Transaction\List_product;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ListProductController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'transaction');
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
        //
        $list_product_model = new List_product();
        $list_product =  $list_product_model->select('*')
            ->paginate(15);

        return view('admin.list_product.list',compact('list_product'));
    }
     public function list_employee_intro()
        {
            //
            $employee_intro_employer_model = new Employee_intro_employer();
            $list_intro =  $employee_intro_employer_model->select('*')
                ->paginate(20);

            return view('admin.list_product.list',compact('list_intro'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.list_product.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_image' => 'required',
            'product_link' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'product_name.required' => 'Tên sản phẩm không được để trống.',
            'product_price.required' => 'Giá sản phẩm không được để trống.',
            'product_discount.required' => 'Giá sản phẩm trên sanketoan không được để trống.',
            'product_image.required' => 'Ảnh sản phẩm không được để trống.',
            'product_link.required' => 'Link sản phẩm không được để trống.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $list_product_model = new List_product();
            $product_id = $list_product_model->insertGetId([
                'product_name' => $request->input('product_name'),
                'product_price' =>str_replace(".","",$request->input('product_price')),
                'product_discount' =>str_replace(".","",$request->input('product_discount')),
                'product_image' => $request->input('product_image'),
                'product_content' => $request->input('product_content'),
                'product_link' => $request->input('product_link'),
                'created_at' => new \DateTime(),
            ]);
            $slug = \App\Ultility\Ultility::createSlug($request->input('product_name'));
            $postWithSlug = $list_product_model->where('product_slug', $slug)->first();
            if (empty($postWithSlug)) {
               $update = $list_product_model->where('product_id', '=', $product_id)
                    ->update([
                        'product_slug' => $slug
                    ]);
            } else {
                $update = $list_product_model->where('product_id', '=', $product_id)
                    ->update([
                        'product_slug' => $slug.'-'.$product_id
                    ]);
            }

            DB::commit();
            return redirect(route('list_product.index'))->with('success','Thêm mới sản phẩm đổi xu thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('list_product.index'))->with('error', 'Thêm mới sản phẩm đổi xu thất bại');
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
    public function edit(Request $request ,$product_id)
    {
        //
        $list_product_model = new List_product();
        $product = $list_product_model->where('product_id',$product_id)->first();
        if(!empty($product))
        {
            return view('admin.list_product.edit',compact('product'));
        }
        {
            return redirect(route('list_product.index'))->with('error', 'Không tìm thấy sản phẩm này');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $validation = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_image' => 'required',
            'product_link' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'product_name.required' => 'Tên sản phẩm không được để trống.',
            'product_price.required' => 'Giá sản phẩm không được để trống.',
            'product_discount.required' => 'Giá sản phẩm trên sanketoan không được để trống.',
            'product_image.required' => 'Ảnh sản phẩm không được để trống.',
            'product_link.required' => 'Link sản phẩm không được để trống.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $list_product_model = new List_product();
            $update_product = $list_product_model->where('product_id',$product_id)->update([
                'product_name' => $request->input('product_name'),
                'product_price' =>str_replace(".","",$request->input('product_price')),
                'product_discount' =>str_replace(".","",$request->input('product_discount')),
                'product_image' => $request->input('product_image'),
                'product_content' => $request->input('product_content'),
                'product_link' => $request->input('product_link'),
                'updated_at' => new \DateTime(),
            ]);
            $slug = \App\Ultility\Ultility::createSlug($request->input('product_name'));
            $postWithSlug = $list_product_model::where('product_slug', $slug)
                ->where('product_id', '!=', $product_id)
                ->first();
            if (empty($postWithSlug)) {
                $update = $list_product_model->where('product_id', $product_id)
                    ->update([
                        'product_slug' => $slug
                    ]);
            } else {
                $update = $list_product_model->where('product_id', $product_id)
                    ->update([
                        'product_slug' => $slug.'-'.$product_id
                    ]);
            }

            DB::commit();
            return redirect(route('list_product.index'))->with('success','Sửa sản phẩm đổi xu thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('list_product.index'))->with('error', 'Sửa sản phẩm đổi xu thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        //
        $list_product_model = new List_product();
        $delete = $list_product_model->where('product_id',$product_id)->delete();
        return redirect(route('list_product.index'))->with('success','Sửa sản phẩm đổi xu thành công');

    }
}
