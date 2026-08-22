<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\VoucherCategories;
use App\Http\Controllers\Site\CkedittorController;

class ArchivesController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'tailieu');
            return $next($request);
        });
    }
    public function index(){
        
        $categorysvoucher = new VoucherCategories();
        $listcates = $categorysvoucher->select('*')->orderBy('id_cate_voucher', 'asc');
        $listcates = $listcates->paginate('10');
        $total = $categorysvoucher->count();
        return view('staff_admin.archives.voucher_categories', compact('listcates','total'));
    }
    public function create(){
        return view('staff_admin.archives.add_voucher_categories');
    }
    public function edit($id){
        $categorysvoucher = new VoucherCategories();
        $cate_gory_voucher = $categorysvoucher->select('*')->orderBy('id_cate_voucher', 'asc')
            ->where('id_cate_voucher',$id)
            ->first();
        return View('staff_admin.archives.edit_voucher_categories', compact('cate_gory_voucher'));
    }
    public function update(Request $request, $id_cate_voucher)
    {
        try {
            $category_voucher = new VoucherCategories();
            $slug_cate_voucher = $request->input('slug_cate_voucher');
            if (empty($slug_cate_voucher)) {
                $slug_cate_voucher = Ultility::createSlug($request->input('name_cate_voucher'));
            }
            $category_voucher->where('id_cate_voucher', '=', $id_cate_voucher)
                ->update([
                    'name_cate_voucher' => $request->input('name_cate_voucher'),
                    'icon' => $request->input('icon'),
                    'meta_title' => $request->input('meta_title'),
                    'meta_description' => $request->input('meta_description'),
                    'meta_keyword' => $request->input('meta_keyword'),
                ]);
            $postWithSlug = $category_voucher->where('slug_cate_voucher', $slug_cate_voucher)
                ->where('id_cate_voucher','!=', $id_cate_voucher
                )->first();
            if (empty($postWithSlug)) {
                $category_voucher->where('id_cate_voucher', '=', $id_cate_voucher)
                    ->update([
                        'slug_cate_voucher' => $slug_cate_voucher
                    ]);
            } else {
                $category_voucher->where('id_cate_voucher', '=', $id_cate_voucher)
                    ->update([
                        'slug_cate_voucher' => $slug_cate_voucher . '-' . $id_cate_voucher
                    ]);
            }
            return redirect('staff/staff_archives')->with('success', 'Sửa kho tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_archives')->with('error', 'Sửa kho tài liệu thất bại');
        }
    }
    public function show(){
        
    }
    public function destroy(Request $request, $id_cate_voucher)
    {
        try {
            $category_voucher = new VoucherCategories();
            $category_voucher->where('id_cate_voucher', '=', $id_cate_voucher)
                ->delete();
            return redirect(route('staff_archives.index'))->with('success', 'Xóa kho tài liệu thành công');
        } catch (\Exception $e) {
            return redirect(route('staff_archives.index'))->with('error', 'Xóa kho tài liệu thất bại');
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            VoucherCategories::where('id_cate_voucher', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
