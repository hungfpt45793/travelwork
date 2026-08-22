<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Educate_categories;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;
use Illuminate\Support\Facades\Auth;

class EducateCategoriesController extends SiteStaffController
{
    protected $role;

    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
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
        $educate_categories = $educate_categories->paginate(20);
        $educate_categories->appends(request()->query());
        return view('staff_admin.educate_categories.list', compact('educate_categories'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff_admin.educate_categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $edu_cate_slug = $request->input('edu_cate_slug');

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
            return redirect(route('educateCategories.index'))->with('success','Thêm thành công');
        }catch (\Exception $e)
        {
            return redirect(route('educateCategories.index'))->with('error','Thêm thất bại');
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
        $educate_categories = new Educate_categories();
        $educate_categorie = $educate_categories->where('edu_cate_id',$id)->first();
        return view('staff_admin.educate_categories.edit', compact('educate_categorie'));
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
            $edu_cate_slug = $request->input('edu_cate_slug');

            $educate_categories = new Educate_categories();
            $edu_cate_id = $educate_categories->where('edu_cate_id',$id)->update([
                'edu_cate_title' => $request->input('edu_cate_title'),
                'edu_cate_image' => $request->input('edu_cate_image'),
                'edu_cate_des' => $request->input('edu_cate_des'),
                'edu_cate_content' => $request->input('edu_cate_content'),
                'user_id' => Auth::user()->id,
                'updated_at' => new \DateTime(),
            ]);

            $postWithSlug = $educate_categories->where('edu_cate_slug', $edu_cate_slug)->where('edu_cate_id', '!=', $request->edu_cate_id)->first();
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
            return redirect(route('educateCategories.index'))->with('success','Cập nhật thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function educateCategoriesDestroy($id)
    {
        $educate_categories = new Educate_categories();
        $edu_cate_id = $educate_categories->where('edu_cate_id',$id)->delete();
        return redirect(route('educateCategories.index'))->with('success','Xóa thành công');
    }
}
