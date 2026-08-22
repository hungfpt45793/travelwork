<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Staff\SiteStaffController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\VoucherChildCategories;
use App\Entity\VoucherCategories;
use App\Entity\Ultility;

class CategoryDocumentController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'tailieu');
            return $next($request);
        });
    }
    public function index(Request $request){
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $categorysvoucher = new VoucherChildCategories();
        $listcates = $categorysvoucher->select('*')->join('voucher_categories','voucher_categories.id_cate_voucher','=','voucher_child_categories.id_cate_voucher')->orderBy('voucher_child_categories.id_cate_voucher','desc');
        $total = $listcates->count();
        $listcates = $listcates->paginate($num);
        return View('staff_admin.document_category.index', compact('listcates','total'));
    }
    public function create(){
        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher','asc')->get();
        return View('staff_admin.document_category.create',compact('lists'));
    }
    public function store(Request $request)
    {
        $category_child_voucher = new VoucherChildCategories();
        $cate_child_id = $category_child_voucher->insertGetId([
            'name_cate_child' => $request->input('name_cate_child'),
            'id_cate_voucher' => $request->input('id_cate_voucher'),
            'des_cate_child' => $request->input('des_cate_child'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);
        $slug_cate_child = $request->input('slug_cate_child');
        if (empty($slug_cate_child)) {
            $slug_cate_child = Ultility::createSlug($request->input('name_cate_child'));
        }
        $postWithSlug = $category_child_voucher->where('slug_cate_child', $slug_cate_child)->first();
        if (empty($postWithSlug)) {
            $category_child_voucher->where('id_cate_child', '=', $cate_child_id)
                ->update([
                    'slug_cate_child' => $slug_cate_child
                ]);
        } else {
            $category_child_voucher->where('id_cate_child', '=', $cate_child_id)
                ->update([
                    'slug_cate_child' => $slug_cate_child . '-' . $cate_child_id
                ]);
        }
        return redirect('staff/staff_category_document')->with('success', 'Thêm danh mục tài liệu thành công');
    }
    public function edit(Request $request, $id_cate_child)
    {
        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher','asc')->get();

        $category_child_voucher = new VoucherChildCategories();
        $category_child_voucher = $category_child_voucher->select('*')->orderBy('id_cate_voucher', 'asc')
            ->where('id_cate_child',$id_cate_child)
            ->first();
        return View('staff_admin.document_category.edit', compact('category_child_voucher','lists'));
    }

    public function update(Request $request, $id_cate_child)
    {
        try {
            $category_child = new VoucherChildCategories();

            $slug_cate_child = $request->input('slug_cate_child');
            if (empty($slug_cate_child)) {
                $slug_cate_child = Ultility::createSlug($request->input('name_cate_child'));
            }
            $category_child->where('id_cate_child', '=', $id_cate_child)
                ->update([
                    'name_cate_child' => $request->input('name_cate_child'),
                    'id_cate_voucher' => $request->input('id_cate_voucher'),
                    'des_cate_child' => $request->input('des_cate_child'),
                    'meta_title' => $request->input('meta_title'),
                    'meta_description' => $request->input('meta_description'),
                    'meta_keyword' => $request->input('meta_keyword'),
                ]);

            $postWithSlug = $category_child->where('slug_cate_child', $slug_cate_child)
                ->where('id_cate_child','!=', $id_cate_child
                )->first();
            if (empty($postWithSlug)) {
                $category_child->where('id_cate_child', '=', $id_cate_child)
                    ->update([
                        'slug_cate_child' => $slug_cate_child
                    ]);
            } else {
                $category_child->where('id_cate_child', '=', $id_cate_child)
                    ->update([
                        'slug_cate_child' => $slug_cate_child . '-' . $id_cate_child
                    ]);
            }
            return redirect('staff/staff_category_document')->with('success', 'Sửa danh mục tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_category_document')->with('error', 'Sửa danh mục tài liệu thất bại');
        }

    }
    public function destroy(Request $request, $id_cate_child)
    {
        try {
            $category_child = new VoucherChildCategories();
            $category_child = $category_child->where('id_cate_child', '=', $id_cate_child)
                ->delete();
            return redirect('staff/staff_category_document')->with('success', 'Xóa danh mục thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_category_document')->with('error', 'Xóa danh mục thất bại');
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            VoucherChildCategories::where('id_cate_child', $arrid)->delete();
        }

        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
