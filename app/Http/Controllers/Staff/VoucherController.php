<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Category_tag;
use App\Entity\VoucherChildCategories;
use App\Entity\Voucher;
use App\Ultility\Ultility;
use App\Entity\VoucherCategories;

class VoucherController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'tailieu');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $categories_voucher = new VoucherChildCategories();
        $categories_voucher = $categories_voucher->select('*')->get();

        $voucher = new Voucher();
        $vouchers = $voucher->select('*')->orderBy('id_voucher', 'desc');
        if (!empty($request->input('category_voucher'))) {
            $id_cate_voucher = $request->input('category_voucher');
            $vouchers = $vouchers->where('id_cate_child', $id_cate_voucher);
        }
        $num = 20;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $vouchers = $vouchers->whereDate('created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $vouchers = $vouchers->whereDate('created_at', '<=', $request->date_search_end);
        }
        // tìm theo id tai lieu
        if (!empty($request->id_voucher)) {
            $vouchers = $vouchers->where('voucher.id_voucher', $request->id_voucher);
        }
        if (!empty($request->input('name_voucher')))
        {
            $name_voucher = $request->input('name_voucher');
            $vouchers = $vouchers->where('name_voucher', 'like', '%'.$name_voucher.'%');
        }
        $total = $vouchers->count();
        $vouchers = $vouchers->paginate($num);
        $vouchers->appends(request()->query());
        return view('staff_admin.voucher.index', compact('vouchers', 'categories_voucher','total'));
    }

    public function create()
    {
        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher', 'asc')->get();
        $input_tags = Category_tag::all_tags_doc();
        return view('staff_admin.voucher.create', compact('lists','input_tags'));
    }

    public function store(Request $request)
    {
        $sale_money = 0;
        if(!empty($request->input('sale_money')))
        {
            $sale_money = $request->input('sale_money');
        }

        // thêm tag
        $tags = "";
        foreach ($request->input('tags') as $tag)
        {
            $tags .= $tag.',';
        }
        $tags = rtrim($tags, ",");
        // END thêm tag

        $vouchers = new Voucher();
        $inserGetid = $vouchers->insertGetId([
            'name_voucher' => $request->input('name_voucher'),
            'des_voucher' => $request->input('des_voucher'),
            'image_voucher' => $request->input('image_voucher'),
            'content_voucher' => $request->input('content_voucher'),
            'tags' => $tags,
            'id_cate_child' => $request->input('id_cate_child'),
            'link_dowload_file' => $request->input('link_dowload_file'),
            'sale_money' => $sale_money,
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);
        //them slug
        $slug_voucher = $request->input('slug_voucher');
        if (empty($slug_voucher)) {
            $slug_voucher = Ultility::createSlug($request->input('name_voucher'));
        }
//        $postWithSlug = $post->where('slug', $slug)->first();
        $voucher = $vouchers->where('slug_voucher', $slug_voucher)->first();
        if (empty($voucher)) {
            $vouchers->where('id_voucher', '=', $inserGetid)
                ->update([
                    'slug_voucher' => $slug_voucher
                ]);
        } else {
            $vouchers->where('id_voucher', '=', $inserGetid)
                ->update([
                    'slug_voucher' => $slug_voucher . '-' . $inserGetid
                ]);
        }
        if ($request->hasFile('link_dowload_voucher')) {
            $file = $request->link_dowload_voucher;
            $maxsize = 10500000;  //khoang 10Mb
            if ($file->getSize() >= $maxsize) {
                return redirect(route('staff_voucher.create'))->with('error', 'File quá lớn không thể upload');
            }

            $name_file = Ultility::createSlug($file->getClientOriginalName()) . $inserGetid . '.' . $file->getClientOriginalExtension();

            $type = $file->getClientOriginalExtension();
            $file->move('upload', $name_file);
            $vouchers->where('id_voucher', '=', $inserGetid)
                ->update([
                    'type_voucher' => $type,
                    'link_dowload_voucher' => $name_file,
                ]);
        }
        return redirect('staff/staff_voucher');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_voucher)
    {
        $vouchers = new Voucher();
        $voucher = $vouchers->select('*')->where('id_voucher', $id_voucher)->first();

        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher', 'asc')->get();
        $input_tags = Category_tag::all_tags_doc();
        return view('staff_admin.voucher.edit', compact('voucher', 'lists','input_tags'));
    }

    public function update(Request $request, $id_voucher)
    {
        try {
            $sale_money = 0;
            if(!empty($request->input('sale_money')))
            {
                $sale_money = $request->input('sale_money');
            }
            $voucher = new Voucher();
            $voucher_slug = $request->input('slug_voucher');
            if (empty($voucher_slug)) {
                $voucher_slug = Ultility::createSlug($request->input('name_voucher'));
            }
            // thêm tag
            $tags = "";
            foreach ($request->input('tags') as $tag)
            {
                $tags .= $tag.',';
            }
            $tags = rtrim($tags, ",");
            // END thêm tag
            $update = $voucher->where('id_voucher', $id_voucher)->update([
                'name_voucher' => $request->input('name_voucher'),
                'des_voucher' => $request->input('des_voucher'),
                'image_voucher' => $request->input('image_voucher'),
                'content_voucher' => $request->input('content_voucher'),
                'tags' => $tags,
                'id_cate_child' => $request->input('id_cate_child'),
                'link_dowload_file' => $request->input('link_dowload_file'),
                'sale_money' =>  $sale_money,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
            ]);
            $postWithSlug = $voucher->where('slug_voucher', $voucher_slug)
                ->where('id_voucher', '!=', $id_voucher)
                ->first();
            if (empty($postWithSlug)) {
                $voucher->where('id_voucher', $id_voucher)
                    ->update([
                        'slug_voucher' => $voucher_slug
                    ]);
            } else {
                $voucher->where('id_voucher', $id_voucher)
                    ->update([
                        'slug_voucher' => $voucher_slug . '-' . $id_voucher
                    ]);
            }
            if (!empty($request->input('checkUploadFile'))) {
                if ($request->hasFile('link_dowload_voucher')) {
                    $list = $voucher->select('*')->where('id_voucher', $id_voucher)->first();
                    if (file_exists($list->link_dowload_voucher))
                    {
                        unlink(public_path('upload/' . $list->link_dowload_voucher));
                    }
                    $file = $request->link_dowload_voucher;
                    $maxsize = 10500000;  //khoang 10Mb
                    if ($file->getSize() >= $maxsize) {
                        return redirect(route('voucher.update', ['id_voucher' => $id_voucher]))->with('error', 'File quá lớn không thể upload');
                    }
                    $name_file = Ultility::createSlug($file->getClientOriginalName()) . $id_voucher . '.' . $file->getClientOriginalExtension();


                    $type = $file->getClientOriginalExtension();
                    $file->move('upload', $name_file);
                    $voucher->where('id_voucher', '=', $id_voucher)
                        ->update([
                            'type_voucher' => $type,
                            'link_dowload_voucher' => $name_file,
                        ]);

                }
            }
            return redirect('staff/staff_voucher')->with('success', 'Sửa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_voucher')->with('error', 'Sửa  tài liệu thất bại');
        }

    }

    public function destroy(Request $request, $id_voucher)
    {
        try {
            $voucher = new Voucher();
            $list = $voucher->select('*')->where('id_voucher', $id_voucher)->first();
            if ($request->hasFile($list->link_dowload_voucher)) {
                unlink(public_path('upload/' . $list->link_dowload_voucher));
            }
            $delete = $voucher->where('id_voucher', $id_voucher)->delete();
            return redirect('staff/staff_voucher')->with('success', 'Xóa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_voucher')->with('error', 'Xóa tài liệu thất bại');
        }


    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Voucher::where('id_voucher', $arrid)->delete();
        }

        return response()->json(['success'=>"Products Deleted successfully."]);
    }
    public function list_deleted(Request $request)
    {
        $categories_voucher = new VoucherChildCategories();
        $categories_voucher = $categories_voucher->select('*')->get();

        $voucher = new Voucher();
        $vouchers = $voucher->select('*')->orderBy('id_voucher', 'desc');
        if (!empty($request->input('category_voucher'))) {
            $id_cate_voucher = $request->input('category_voucher');
            $vouchers = $vouchers->where('id_cate_child', $id_cate_voucher);
        }
        $num = 20;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $vouchers = $vouchers->whereDate('created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $vouchers = $vouchers->whereDate('created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('name_voucher')))
        {
            $name_voucher = $request->input('name_voucher');
            $vouchers = $vouchers->where('name_voucher', 'like', '%'.$name_voucher.'%');
        }
        $total = $vouchers->count();
        $vouchers = $vouchers->onlyTrashed();
        $vouchers = $vouchers->paginate($num);
        $vouchers->appends(request()->query());
        return view('staff_admin.voucher.list_deleted', compact('vouchers', 'categories_voucher','total'));
    }
    public function deleteHard($voucher_id)
    {
        Voucher::where('id_voucher', $voucher_id)->forceDelete();
        return redirect()->back()->with('success','Xóa hẳn thành công !!!');
    }
    public function voucher_srestore(Request $request, $voucher_id)
    {
        $vouchers_model = new Voucher();
        $restore = $vouchers_model->withTrashed()->where('id_voucher', $voucher_id)->restore();
        return redirect()->back()->with('success','Khôi phục thành công');
    }
    public function deleteAllHard(Request $request)
    {
        // dd(1);
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Voucher::where('id_voucher', $arrid)->forceDelete();
        }
            return response()->json(['success'=>"Xóa hẳn thành công !!!"]);

    }
}
