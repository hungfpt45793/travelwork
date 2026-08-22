<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Category_tag;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryTagController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'danhmuc');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        // $tag_type = 1 bài viết , 2 tài liệu , 3 công viec
        $num = 20;
        if(!empty($request->num)) {
            $num = $request->num;
        }
        $tag_type = $request->input('tag_type');
        $category_tag = Category_tag::select('*')->where('tag_type',$tag_type);
        if(!empty($request->input('tag_title')))
        {
            $tag_title = $request->input('tag_title');
            $category_tag = $category_tag->where('tag_title','like','%'.$tag_title.'%');
        }
        if(!empty($request->input('tag_key')))
        {
            $tag_keyword = $request->input('tag_key');
            $category_tag = $category_tag->where('tag_keyword','like','%'.$tag_keyword.'%');
        }
        if(!empty($request->input('tag_description')))
        {
            $tag_description = $request->input('tag_description');
            $category_tag = $category_tag->where('tag_description','like','%'.$tag_description.'%');
        }
        $total = $category_tag->count();
        $all = $request->all();
        $category_tag = $category_tag->orderBy('tag_id','desc')->paginate($num);
        $category_tag->appends($all);
        
        return view('staff_admin.category_tag.list',compact('category_tag','tag_type','total'));
    }

    public function create()
    {
        //
        return view('staff_admin.category_tag.add');
    }

    public function them_tu_khoa_ajax (Request $request)
    {
        $tag_type = $request->tag_type;
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
        return redirect(route('tag-category.index').'?tag_type='.$tag_type)->with('success','Thêm danh mục tag thành công');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
        $category_tag = Category_tag::select('*')->where('tag_id',$id)->first();
        return view('staff_admin.category_tag.edit',compact('category_tag'));
    }

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

        return redirect(route('tag-category.index').'?tag_type='.$tag_type)->with('success','Cập nhật danh mục tag thành công');
    }

    public function destroy($id)
    {
        $category_tag = Category_tag::select('*')->where('tag_id',$id)->first();
        $tag_type = $category_tag->tag_type;
        $delete = Category_tag::select('*')->where('tag_id',$id)->delete();
        return redirect()->back()->with('success','Xóa danh mục tag thành công');
    }

    public function delete_all(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
   
        foreach ($arrids as $arrid) {
            Category_tag::where('tag_id', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
