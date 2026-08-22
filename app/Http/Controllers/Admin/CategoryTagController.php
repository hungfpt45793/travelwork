<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category_tag;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryTagController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        // $tag_type = 1 bài viết , 2 tài liệu , 3 công viec
        $tag_type = $request->input('tag_type');
        $category_tag = Category_tag::select('*')->where('tag_type',$tag_type);
        if(!empty($request->input('tag_title')))
        {
            $tag_title = $request->input('tag_title');
            $category_tag = $category_tag->where('tag_title','like','%'.$tag_title.'%');
        }
         $category_tag = $category_tag->paginate(20);
        $category_tag->appends(request()->query());
        return view('admin.category_tag.list',compact('category_tag','tag_type'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category_tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function them_tu_khoa_ajax (Request $request)
    {
        $tag_type = $request->input('tag_type');
        $tag_id = Category_tag::insertGetId([
           'tag_title' => $request->tag_title,
           'tag_description' => $request->tag_description,
           'tag_type' => $tag_type,
           'created_at' => new \DateTime()
        ]);
        $tag_slug = Ultility::createSlug($request->input('tag_title'));

        $postWithSlug = Category_tag::where('tag_slug', $tag_slug)->first();
        if (empty($postWithSlug)) {
            Category_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Category_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug.'-'.$tag_id
                ]);
        }
        $input_tags_reload = Category_tag::all_tags_post();
        return response()->json([
            'success' => 200,
            'input_tags_reload' => $input_tags_reload
        ]);
    }

    public function store(Request $request)
    {
        //
        $tag_type = $request->input('tag_type');
        $tag_id = Category_tag::insertGetId([
           'tag_title' => $request->input('tag_title'),
           'tag_description' => $request->input('tag_description'),
           'tag_keyword' => $request->input('tag_keyword'),
           'tag_type' => $tag_type,
           'created_at' => new \DateTime()
        ]);
        $tag_slug = Ultility::createSlug($request->input('tag_title'));

        $postWithSlug = Category_tag::where('tag_slug', $tag_slug)->first();
        if (empty($postWithSlug)) {
            Category_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Category_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug.'-'.$tag_id
                ]);
        }
        return redirect(route('category-tag.index').'?tag_type='.$tag_type)->with('success','Thêm danh mục tag thành công');
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
    public function edit($id)
    {
        //
        $category_tag = Category_tag::select('*')->where('tag_id',$id)->first();
        return view('admin.category_tag.edit',compact('category_tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag_type = $request->input('tag_type');
        $tag_id = Category_tag::where('tag_id',$id)->update([
            'tag_title' => $request->input('tag_title'),
            'tag_description' => $request->input('tag_description'),
            'tag_keyword' => $request->input('tag_keyword'),
            'tag_type' => $tag_type,
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('category-tag.index').'?tag_type='.$tag_type)->with('success','Cập nhật danh mục tag thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_tag = Category_tag::select('*')->where('tag_id',$id)->first();
        $tag_type = $category_tag->tag_type;
        $delete = Category_tag::select('*')->where('tag_id',$id)->delete();
        return redirect(route('category-tag.index').'?tag_type='.$tag_type)->with('success','Xóa danh mục tag thành công');
    }
}
