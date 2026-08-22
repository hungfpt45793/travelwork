<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Coin_type_information_employer;
use App\Entity\Domain;
use App\Entity\Theme;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Matcher\Type;
use Validator;
use App\Ultility\Ultility;

class Coin_type_infomation_employerController extends AdminController
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
            view()->share('menuTop', 'employer_coin');
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
            $typeInformations = Coin_type_information_employer::orderBy('type_infor_id')
                ->get();

            return View('admin.coin.coin_type_information_employer.list', compact('typeInformations'));
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
        return View('admin.coin.coin_type_information_employer.add');
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
            $user_id = Auth::user()->id;
            // excuse input_default
            $typeInput = $request->input('type_input');

            // insert to database
            $typeInformation = new Coin_type_information_employer();
            $inser_id = $typeInformation->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
                'type_input' => $typeInput,
                'user_id' =>$user_id,
                'placeholder' => $request->input('placeholder')
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->store: Lỗi xảy tra trong quá trình thêm mới kiểu thông tin');
        } finally {
            return redirect('admin/coin_type_information_employer');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function show(Coin_type_information_employer $typeInformation)
    {
        return redirect('admin/coin_type_information_employer');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function edit($type_infor_id)
    {
        $typeInformation_money_model = new Coin_type_information_employer();
        $typeInformation = $typeInformation_money_model->select('*')->where('type_infor_id',$type_infor_id)->first();
//        print_r($typeInformation);die();
        return View('admin.coin.coin_type_information_employer.edit', compact('typeInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type_infor_id)
    {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            $user_id = Auth::user()->id;
            // excuse input_default
            $typeInput = $request->input('type_input');
            $typeInformation_money_model = new Coin_type_information_employer();
            // update to database
            $typeInformation_money_model->where('type_infor_id',$type_infor_id)
                ->update([
                    'title' => $request->input('title'),
                    'slug' => $slug,
                    'type_input' => $typeInput,
                    'user_id' =>$user_id,
                    'placeholder' => $request->input('placeholder')
                ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->update: Lỗi xảy tra trong quá trình chỉnh sửa kiểu thông tin');
        } finally {
            return redirect('admin/coin_type_information_employer ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\TypeInformation  $typeInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy($type_infor_id)
    {
        try {
            $typeInformation_money_model = new Coin_type_information_employer();
            $delete = $typeInformation_money_model->where('type_infor_id',$type_infor_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa kiểu thông tin: dữ liệu không hợp lệ.');
            Log::error('http->admin->TypeInformationController->destroy: Lỗi xảy tra trong quá trình xóa kiểu thông tin');
        } finally {
            return redirect('admin/type-information-money');
        }
    }
}
