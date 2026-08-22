<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Information_money;
use App\Entity\InformationGeneral;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Entity\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InformationMoneyController extends AdminController
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
            view()->share('menuTop', 'transaction');
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

        $typeInformations = $this->getTypeInformations();

        // get information
        $informations = $this->getInformation();
        $typeInformations = $this->getContentInformation($typeInformations, $informations);

        return View('admin.information_money.index', compact('typeInformations'));
    }

    private function getTypeInformations() {
        try {
            $typeInformations = TypeInformation_money::orderBy('type_infor_id')
                ->get();

            return $typeInformations;
        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->getTypeInformations: Lỗi lấy kiểu thông tin.');
            Error::setErrorMessage('Lỗi lây thông tin website.');

            return null;
        }
    }

    private function getInformation() {
        try  {
            $informations = Information_money::get();

            return $informations;
        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->getInformation: Lỗi lấy  thông tin.');
            Error::setErrorMessage('Lỗi lây thông tin website.');

            return null;
        }
    }

    private function getContentInformation($typeInformations, $informations) {
        try {
            foreach($typeInformations as $id => $typeInformation) {
                $typeInformations[$id]['information'] = '';
                foreach ($informations as $information) {
                    if ($information->slug_type_input == $typeInformation->slug) {
                        $typeInformations[$id]['information'] = $information->content;
                        break;
                    }
                }
            }

            return $typeInformations;
        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->getContentInformation: Lỗi lấy  thông tin.');
            Error::setErrorMessage('Lỗi lây thông tin website.');

            return null;
        }
    }
    /**
     *  Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $slugTypeInputs = $request->input('slug_type_input');
            $contents = $request->input('content');
            foreach($slugTypeInputs as  $id => $slugTypeInput) {
                $content = $contents[$id];
                $information = Information_money::where('slug_type_input', $slugTypeInput)->first();
                // insert information
                if (empty($information)) {
                    $information = new Information_money();
                    $information->insert([
                        'slug_type_input' => $slugTypeInput,
                        'content' => $content,
                    ]);

                    continue;
                }
                //update information
                $information->update([
                    'content' => $content,
                ]);
            }

            return redirect('admin/information-money');
        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->store: cập nhật thông tin');
            Error::setErrorMessage('cập nhật thông tin lỗi: dữ liệu nhập vào không hợp lệ.');

            return redirect('admin/information-money');
        }
    }


}
