<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryPost;
use App\Entity\CategoryVoucher;
use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\PostFacebook;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Facebook\Fanpage;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Validator;
use Yajra\DataTables\DataTables;

class VoucherCategoriesController extends AdminController
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
            view()->share('menuTop', 'voucher');
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
        $categorysvoucher = new VoucherCategories();
        $listcates = $categorysvoucher->select('*')->orderBy('id_cate_voucher', 'asc')->paginate('10');
        return View('voucher.voucher_categories.index', compact('listcates'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('voucher.voucher_categories.add');
    }

    public function store(Request $request)
    {
//        echo 1;die();
        $category_voucher = new VoucherCategories();
        $cate_voucher_id = $category_voucher->insertGetId([
            'name_cate_voucher' => $request->input('name_cate_voucher'),
            'icon' => $request->input('icon'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),

        ]);
        $slug_cate_voucher = $request->input('slug_cate_voucher');
        if (empty($slug_cate_voucher)) {
            $slug_cate_voucher = Ultility::createSlug($request->input('name_cate_voucher'));
        }
        $postWithSlug = $category_voucher->where('slug_cate_voucher', $slug_cate_voucher)->first();
        if (empty($postWithSlug)) {
            $category_voucher->where('id_cate_voucher', '=', $cate_voucher_id)
                ->update([
                    'slug_cate_voucher' => $slug_cate_voucher
                ]);
        } else {
            $category_voucher->where('id_cate_voucher', '=', $cate_voucher_id)
                ->update([
                    'slug_cate_voucher' => $slug_cate_voucher . '-' . $cate_voucher_id
                ]);
        }
        return redirect(route('voucher-categories.index'))->with('success', 'Thêm kho tài liệu thành công');

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
    public function edit(Request $request, $id_cate_voucher)
    {
        $categorysvoucher = new VoucherCategories();
        $cate_gory_voucher = $categorysvoucher->select('*')->orderBy('id_cate_voucher', 'asc')
            ->where('id_cate_voucher',$id_cate_voucher)
            ->first();
        return View('voucher.voucher_categories.edit', compact('cate_gory_voucher'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
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
            return redirect('admin/voucher-categories')->with('success', 'Sửa kho tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher-categories')->with('error', 'Sửa kho tài liệu thất bại');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_cate_voucher)
    {
        try {
            $category_voucher = new VoucherCategories();
            $category_voucher->where('id_cate_voucher', '=', $id_cate_voucher)
                ->delete();
            return redirect(route('voucher-categories.index'))->with('success', 'Xóa kho tài liệu thành công');
        } catch (\Exception $e) {
            return redirect(route('voucher-categories.index'))->with('error', 'Xóa kho tài liệu thất bại');
        }
    }
}
