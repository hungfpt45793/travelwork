<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryChildVoucher;
use App\Entity\CategoryPost;
use App\Entity\CategoryVoucher;
use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\Category_tag;
use App\Entity\Post;
use App\Entity\PostFacebook;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Entity\Voucher;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Facebook\Fanpage;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Validator;
use Yajra\DataTables\DataTables;

class VoucherController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'voucher');

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//

        $categories_voucher = new VoucherChildCategories();
        $categories_voucher = $categories_voucher->select('*')->get();

        $voucher = new Voucher();
        $vouchers = $voucher->select('*')->orderBy('id_voucher', 'desc');
        if (!empty($request->input('category_voucher'))) {
            $id_cate_voucher = $request->input('category_voucher');
            $vouchers = $vouchers->where('id_cate_child', $id_cate_voucher);
        }
        if (!empty($request->input('name_voucher')))
        {
            $name_voucher = $request->input('name_voucher');
            $vouchers = $vouchers->where('name_voucher', 'like', '%'.$name_voucher.'%');
        }
        $total = $vouchers->count();
        $vouchers = $vouchers->paginate(10);
        $vouchers->appends(request()->query());
        return view('voucher.voucher.index', compact('vouchers', 'categories_voucher','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher', 'asc')->get();
        $input_tags = Category_tag::all_tags_doc();
        return view('voucher.voucher.add', compact('lists','input_tags'));
//        <input type="file" name="cover">
    }

    public function store(Request $request)
    {
        $sale_money = 0;
        if(!empty($request->input('sale_money')))
        {
            $sale_money = $request->input('sale_money');
        }
        $vouchers = new Voucher();
        $inserGetid = $vouchers->insertGetId([
            'name_voucher' => $request->input('name_voucher'),
            'des_voucher' => $request->input('des_voucher'),
            'image_voucher' => $request->input('image_voucher'),
            'content_voucher' => $request->input('content_voucher'),
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
                return redirect(route('voucher.create'))->with('error', 'File quá lớn không thể upload');
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
        return redirect('admin/voucher');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_voucher)
    {
        $vouchers = new Voucher();
        $voucher = $vouchers->select('*')->where('id_voucher', $id_voucher)->first();

        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher', 'asc')->get();
        return View('voucher.voucher.edit', compact('voucher', 'lists'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
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
            $update = $voucher->where('id_voucher', $id_voucher)->update([
                'name_voucher' => $request->input('name_voucher'),
                'des_voucher' => $request->input('des_voucher'),
                'image_voucher' => $request->input('image_voucher'),
                'content_voucher' => $request->input('content_voucher'),
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
            return redirect('admin/voucher')->with('success', 'Sửa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher')->with('error', 'Sửa  tài liệu thất bại');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_voucher)
    {
        try {
            $voucher = new Voucher();
            $list = $voucher->select('*')->where('id_voucher', $id_voucher)->first();
            if ($request->hasFile($list->link_dowload_voucher)) {
                unlink(public_path('upload/' . $list->link_dowload_voucher));
            }
            $delete = $voucher->where('id_voucher', $id_voucher)->delete();
            return redirect('admin/voucher')->with('success', 'Xóa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher')->with('error', 'Xóa tài liệu thất bại');
        }


    }


}
