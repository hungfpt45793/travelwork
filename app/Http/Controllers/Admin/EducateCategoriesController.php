<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Educate_categories;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EducateCategoriesController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'educate');
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
        $educate_categories = new Educate_categories();
        $educate_categories = $educate_categories->select('*')->orderBy('edu_cate_id','desc');
        $total = $educate_categories->count();
        $educate_categories = $educate_categories->paginate(20);
        $educate_categories->appends(request()->query());
        return view('admin.education.educate_categories.list', compact('educate_categories', 'total'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.education.educate_categories.add', compact('educate_categories', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try
        {
            $edu_cate_slug = Ultility::createSlug($request->input('edu_cate_title'));

            $educate_categories = new Educate_categories();
            $edu_cate_id = $educate_categories->insertGetId([
                'edu_cate_title' => $request->input('edu_cate_title'),
                'edu_cate_image' => $request->input('edu_cate_image'),
                'edu_cate_des' => $request->input('edu_cate_des'),
                'edu_cate_content' => $request->input('edu_cate_content'),
                'user_id' => Auth::user()->id,
                'created_at' => new \DateTime(),
            ]);

            $postWithSlug = $educate_categories->where('edu_cate_slug', $edu_cate_slug)->first();
            if (empty($postWithSlug)) {
                $educate_categories->where('edu_cate_id', '=', $edu_cate_id)
                    ->update([
                        'edu_cate_slug' => $edu_cate_slug
                    ]);
            } else {
                $educate_categories->where('edu_cate_id', '=', $edu_cate_id)
                    ->update([
                        'edu_cate_slug' => $edu_cate_slug.'-'.$edu_cate_id
                    ]);
            }
            return redirect('admin/educate_categories')->with('success','Thêm thành công');
        }catch (\Exception $e)
        {
            return redirect('admin/educate_categories')->with('error','Thêm thất bại');
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
    public function edit($id)
    {
        //
        $educate_categories = new Educate_categories();
        $educate_categorie = $educate_categories->where('edu_cate_id',$id)->first();
        return view('admin.education.educate_categories.edit', compact('educate_categorie'));
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
//        try{
            $edu_cate_slug = Ultility::createSlug($request->input('edu_cate_title'));

            $educate_categories = new Educate_categories();
            $edu_cate_id = $educate_categories->where('edu_cate_id',$id)->update([
                'edu_cate_title' => $request->input('edu_cate_title'),
                'edu_cate_image' => $request->input('edu_cate_image'),
                'edu_cate_des' => $request->input('edu_cate_des'),
                'edu_cate_content' => $request->input('edu_cate_content'),
                'user_id' => Auth::user()->id,
                'updated_at' => new \DateTime(),
            ]);

            $postWithSlug = $educate_categories->where('edu_cate_slug', $edu_cate_slug)->first();
            if (empty($postWithSlug)) {
                $educate_categories->where('edu_cate_id', '=', $id)
                    ->update([
                        'edu_cate_slug' => $edu_cate_slug
                    ]);
            } else {
                $educate_categories->where('edu_cate_id', '=', $id)
                    ->update([
                        'edu_cate_slug' => $edu_cate_slug.'-'.$id
                    ]);
            }
            return redirect('admin/educate_categories')->with('success','Cập nhật thành công');
//        }catch (\Exception $e)
//        {
//            return redirect('admin/educate_categories')->with('error','Cập nhật thất bại');
//        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $educate_categories = new Educate_categories();
        $edu_cate_id = $educate_categories->where('edu_cate_id',$id)->delete();
        return redirect('admin/educate_categories');
    }
}
