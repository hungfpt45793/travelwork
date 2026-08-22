<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Domain;
use App\Entity\Theme;
use App\Entity\TypeSubPost;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Ultility\Ultility;
use Illuminate\Validation\Rule;

class TypeInputController extends AdminController
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
            $typeInputs = TypeInput::orderBy('type_input_id', 'desc')->get();

            return View('admin.type_input.list', compact('typeInputs'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị kiểu trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->index: Lỗi xảy tra trong quá trình hiển thị kiểu trường dữ liệu');

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
        try {
            $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')->get();

            return View('admin.type_input.add', compact('typeSubPosts'));
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị thêm mới trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->create: Lỗi xảy tra trong quá trình thêm mới kiểu trường dữ liệu');

            return redirect('admin/home');
        }

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
            $postUser = implode(',', $request->input('post_used'));

            // inser type_input
            $selectTypeInput = $request->input('type_input');
            if($selectTypeInput == 'list') {
                $selectTypeInput =  $request->input('list');
            }
            // insert to database
            $typeInput = new TypeInput();
            $typeInput->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
                'type_input' => $selectTypeInput,
                'post_used' => $postUser,
                'placeholder' => $request->input('placeholder'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->store: Lỗi xảy tra trong quá trình thêm mới kiểu trường dữ liệu');
        } finally {
            return redirect('admin/type-input');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function show(TypeInput $typeInput)
    {
        return redirect('admin/type-input');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeInput $typeInput
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeInput $typeInput)
    {
        try {
            $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')->get();

            $postUsed = explode(',', $typeInput->post_used);
            return View('admin.type_input.edit', compact('typeInput', 'typeSubPosts', 'postUsed'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị chỉnh sửa trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->edit: Lỗi xảy tra trong quá trình chỉnh sửa kiểu trường dữ liệu');

            return redirect('admin/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeInput $typeInput)
    {
        try {

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            // excuse input_default
            $postUser = implode(',', $request->input('post_used'));

            // inser type_input
            $selectTypeInput = $request->input('type_input');
            if($selectTypeInput == 'list') {
                $selectTypeInput =  $request->input('list');
            }

            // update to database
            $typeInput->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'post_used' => $postUser,
                'placeholder' => $request->input('placeholder'),
                'type_input' => $selectTypeInput,
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị chỉnh sửa trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->update: Lỗi xảy tra trong quá trình chỉnh sửa kiểu trường dữ liệu');
        } finally {
            return redirect('admin/type-input');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeInput  $typeInput
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeInput $typeInput)
    {
        try {

            TypeInput::where('type_input_id', $typeInput->type_input_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa trường dữ liệu: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInputController->destroy: Lỗi xảy tra trong quá trình xóa kiểu trường dữ liệu');
        }finally {
            return redirect('admin/type-input');
        }
    }
}
