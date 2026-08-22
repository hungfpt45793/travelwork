<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryChildVoucher;
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

class VoucherChildCategoriesController extends AdminController
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
        $categorysvoucher = new VoucherChildCategories();
        $listcates = $categorysvoucher->select('*')->join('voucher_categories','voucher_categories.id_cate_voucher','=','voucher_child_categories.id_cate_voucher')->orderBy('voucher_child_categories.id_cate_voucher','desc')
            ->paginate('10');
        return View('voucher.voucher_child_categories.index', compact('listcates'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher','asc')->get();
        return View('voucher.voucher_child_categories.add',compact('lists'));
    }
    public function store(Request $request)
    {
//        echo 1;die();
//        try{
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
        return redirect('admin/voucher-child-categories')->with('success', 'Thêm danh mục tài liệu thành công');
//        }catch (\Exception $e)
//        {
//            return redirect('admin/category-child-voucher')->with('error', 'Thêm danh mục tài liệu thất bại');
//        }
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
    public function edit(Request $request, $id_cate_child)
    {
        $category_voucher = new VoucherCategories();
        $lists = $category_voucher->select('*')->orderBy('id_cate_voucher','asc')->get();

        $category_child_voucher = new VoucherChildCategories();
        $category_child_voucher = $category_child_voucher->select('*')->orderBy('id_cate_voucher', 'asc')
            ->where('id_cate_child',$id_cate_child)
            ->first();
        return View('voucher.voucher_child_categories.edit', compact('category_child_voucher','lists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
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
            return redirect('admin/voucher-child-categories')->with('success', 'Sửa danh mục tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher-child-categories')->with('error', 'Sửa danh mục tài liệu thất bại');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_cate_child)
    {
        try {
            $category_child = new VoucherChildCategories();
            $category_child = $category_child->where('id_cate_child', '=', $id_cate_child)
                ->delete();
            return redirect('admin/voucher-child-categories')->with('success', 'Xóa danh mục thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher-child-categories')->with('error', 'Xóa danh mục thất bại');
        }


    }


}
