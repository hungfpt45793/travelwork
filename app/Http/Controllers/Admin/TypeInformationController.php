<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Domain;
use App\Entity\Theme;
use App\Entity\TypeInformation;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Matcher\Type;
use Validator;
use App\Ultility\Ultility;

class TypeInformationController extends AdminController
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
            $typeInformations = TypeInformation::orderBy('type_infor_id')
                ->get();

            return View('admin.type_information.list', compact('typeInformations'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->index: Lỗi xảy tra trong quá trình hiển thị kiểu thông tin');

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
        return View('admin.type_information.add');
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
            $typeInput = $request->input('type_input');

            // insert to database
            $typeInformation = new TypeInformation();
            $typeInformation->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
                'type_input' => $typeInput,
                'placeholder' => $request->input('placeholder')
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->store: Lỗi xảy tra trong quá trình thêm mới kiểu thông tin');
        } finally {
            return redirect('admin/type-information');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function show(TypeInformation $typeInformation)
    {
        return redirect('admin/type-information');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeInformation $typeInformation)
    {

        return View('admin.type_information.edit', compact('typeInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeInformation $typeInformation)
    {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            // excuse input_default
            $typeInput = $request->input('type_input');

            // update to database
            $typeInformation->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'type_input' => $typeInput,
                'placeholder' => $request->input('placeholder')
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->update: Lỗi xảy tra trong quá trình chỉnh sửa kiểu thông tin');
        } finally {
            return redirect('admin/type-information');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeInformation $typeInformation)
    {
        try {

            TypeInformation::where('type_infor_id', $typeInformation->type_infor_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->destroy: Lỗi xảy tra trong quá trình xóa kiểu thông tin');
        } finally {
            return redirect('admin/type-information');
        }
    }
}
