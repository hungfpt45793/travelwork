<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Career;
use App\Entity\JobCareer;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CareerController extends AdminController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'setting');

            return $next($request);
        });
    }

    public function index()
    {
        $caneer_model  = new Career();
        $caneer =  $caneer_model->select('*')->get();
//        echo '<pre>';
//        print_r($caneer);die;
        return view('admin.setting.career.list',compact('caneer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.career.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'career_category_name' => 'unique:career_categories',
            'view_profile' => 'required|min:0',
            'view_apply' => 'required|min:0',
        ],[
            'career_category_name.unique' => 'Danh mục ngành nghề bạn thêm đã có. Bạn vui lòng nhập tên danh mục việc làm khác.',
            'view_profile.required' => 'Xem hồ sơ không được để trống',
            'view_profile.min' => 'Xem hồ sơ phải lớn hơn 0',
            'view_apply.required' => 'Mời ứng tuyển không được để trống',
            'view_apply.min' => 'Mời ứng tuyển lớn hơn 0',
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            if($request->has('content')){
                $content = $request->input('content');
            }else{
                $content = '';
            }
            $career_model = new Career();
            $career_category_id = $career_model->insertGetId([
                'career_category_name' => $request->input('career_category_name'),
                'career_category_salary' => $request->input('career_category_salary'),
                'content' => $content,
                'slug' => $request->has('slug') ? $request->input('slug') : '',
                'image' => $request->input('image'),
                'view_profile' => $request->input('view_profile'),
                'view_apply' => $request->input('view_apply'),
                'status_show' => $request->input('status_show'),
                'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'created_at'=> new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $slug = Ultility::createSlug($request->input('career_category_name'));
            $postWithSlug = $career_model->where('career_category_slug', $slug)->first();
            if (empty($postWithSlug)) {
                $career_model->where('career_category_id', '=', $career_category_id)
                    ->update([
                        'career_category_slug' => $slug
                    ]);
            } else {
                $career_model->where('career_category_id', '=', $career_category_id)
                    ->update([
                        'career_category_slug' => $slug.'-'.$career_category_id
                    ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect(route('career.index'))->with('error','Thêm thất bại');
        }finally{
            return redirect(route('career.index'))->with('success','Thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function show(Career $career)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function edit(Career $career)
    {
        return view('admin.setting.career.edit', compact('career'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Career $career)
    {
        $validator = Validator::make($request->all(),[
            'career_category_name' => 'required',
            'view_profile' => 'required|min:0',
            'view_apply' => 'required|min:0',
        ],[
            'career_category_name.required' => 'Danh mục ngành nghề không được để trống.',
            'view_profile.required' => 'Xem hồ sơ không được để trống',
            'view_profile.min' => 'Xem hồ sơ phải lớn hơn 0',
            'view_apply.required' => 'Mời ứng tuyển không được để trống',
            'view_apply.min' => 'Mời ứng tuyển lớn hơn 0',
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
            DB::beginTransaction();
            if($request->has('content')){
                $content = $request->input('content');
            }else{
                $content = '';
            }
            $career->update([
                'career_category_name' => $request->input('career_category_name'),
                'career_category_salary' => $request->input('career_category_salary'),
                'content' => $content,
                'slug' => $request->has('slug') ? $request->input('slug') : '',
                'image' => $request->input('image'),
                'view_profile' => $request->input('view_profile'),
                'view_apply' => $request->input('view_apply'),
                'status_show' => $request->input('status_show'),
                'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'updated_at' => new \DateTime()
            ]);
            $career_model = new Career();
            $slug = Ultility::createSlug($request->input('career_category_name'));
            $postWithSlug = $career_model->where('career_category_slug', $slug)->first();
            if (empty($postWithSlug)) {
                $career_model->where('career_category_id', '=', $career->career_category_id)
                    ->update([
                        'career_category_slug' => $slug
                    ]);
            } else {
                $career_model->where('career_category_id', '=', $career->career_category_id)
                    ->update([
                        'career_category_slug' => $slug.'-'.$career->career_category_id
                    ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect(route('career.index'))->with('error','Cập nhật thất bại công');
        }finally{
            return redirect(route('career.index'))->with('success','Cập nhật thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        try{
            DB::beginTransaction();
            $career->delete();
            DB::commit();
        }catch (\Exception $exception){
            Error::setErrorMessage('Không thể xóa dữ liệu. Đã có lỗi xảy ra');
            DB::rollBack();
        }finally{
            return redirect(route('career.index'));
        }
    }

    public function anyDatatable(){
        $careers = Career::select(
            'career_category_id',
            'career_category_name',
            'career_category_salary',
            'career_category_slug',
            'view_profile',
            'view_apply',
            'content',
            'total_jobs',
            'recruit',
            'recruited'
        );

        return Datatables::of($careers)
            ->addColumn('inventory', function ($career){
                $inventory = $career->recruit - $career->recruited;
                return $inventory;
            })
            ->addColumn('action', function ($career){
                $string = '<a href="' . route('career.edit',['career_category_id' => $career->career_category_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('career.destroy', ['career_category_id' => $career->career_category_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('career_category_id','career_category_id desc')
            ->make(true);
    }
}
