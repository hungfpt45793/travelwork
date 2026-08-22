<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Template;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class TypeSubPostController extends AdminController
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
        try {
            $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')->get();

            return View('admin.type_sub_post.list', compact('typeSubPosts'));
        } catch (\Exception $e){
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeSubPostController->index: Lỗi xảy tra trong quá trình hiển thị dạng bài viết');

            return redirect('admin/home');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = Template::getTemplate();
        
        return View('admin.type_sub_post.add', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            // excuse input_default
            $inputDefault = (!empty($request->input('input_default_used'))) ? implode(',', $request->input('input_default_used')) : '';

            // insert to database
            $typeSubPost = new TypeSubPost();
            $typeSubPost->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
                'input_default_used' => $inputDefault,
                'template' => $request->input('template'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeSubPostController->store: Lỗi xảy tra trong quá trình thêm mới dạng bài viết');
        } finally {
            return redirect('admin/type-sub-post');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function show(TypeSubPost $typeSubPost)
    {
        return redirect('admin/type-sub-post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeSubPost $typeSubPost)
    {

        $templates = Template::getTemplate();

        return View('admin.type_sub_post.edit', compact('typeSubPost', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeSubPost $typeSubPost)
    {
        try {

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            // excuse input_default
            $inputDefault = (!empty($request->input('input_default_used'))) ? implode(',', $request->input('input_default_used')) : '';

            // update to database
            $typeSubPost->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'input_default_used' => $inputDefault,
                'template' => $request->input('template'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeSubPostController->update: Lỗi xảy tra trong quá trình chỉnh sửa dạng bài viết');
        } finally {
            return redirect('admin/type-sub-post');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeSubPost  $typeSubPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeSubPost $typeSubPost)
    {
        try {

            TypeSubPost::where('type_sub_post_id', $typeSubPost->type_sub_post_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeSubPostController->destroy: Lỗi xảy tra trong quá trình xóa dạng bài viết');
        } finally {
            return redirect('admin/type-sub-post');
        }

    }
}
