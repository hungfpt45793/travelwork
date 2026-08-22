<?php

namespace App\Http\Controllers\Admin;

use App\Entity\InformationGeneral;
use App\Entity\TypeInformation;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Entity\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InformationController extends AdminController
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

        $typeInformations = $this->getTypeInformations();

        // get information
        $informations = $this->getInformation();
        $typeInformations = $this->getContentInformation($typeInformations, $informations);
        
        return View('admin.information.index', compact('typeInformations'));
    }

    private function getTypeInformations() {
        try {
            $typeInformations = TypeInformation::orderBy('type_infor_id')
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
            $informations = Information::get();

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
                $information = Information::where('slug_type_input', $slugTypeInput)->first();
                // insert information
                if (empty($information)) {
                    $information = new Information();
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

            return redirect('admin/information');
        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->store: cập nhật thông tin');
            Error::setErrorMessage('cập nhật thông tin lỗi: dữ liệu nhập vào không hợp lệ.');

            return redirect('admin/information');
        }
    }

    public function generalCreate(  Request $request)
    {
        $informationGeneralModel = new InformationGeneral();

        $informationGenerals = $informationGeneralModel
            ->get();

        // lay theo element de show ra
        $informationElement  = array();
        foreach ($informationGenerals as $informationGeneral) {
            $informationElement[$informationGeneral->slug] = $informationGeneral->content;
        }


        return view('admin.information.create_general', compact('informationElement'));
    }

    public function generalStore(Request $request) {
        try {
            // lấy tất cả dữ liệu truyền lên ra
            $informationSubmits = $request->all();
            $informationGeneralModel = new InformationGeneral();

            foreach ($informationSubmits as $slug => $content) {
                // Nếu gặp phải biến truyền lên là token thì bỏ qua luôn
                if ($slug == '_token') {
                    continue;
                }

                // khi không phải là token, kiểm tra xem trong db có chưa
                $informationGeneral = $informationGeneralModel->where('slug', $slug)
                    ->first();

                // nếu chưa tồn tại
                if (empty($informationGeneral)) {
                    $informationGeneralModel->insert([
                        'slug' => $slug,
                        'content' => $content,
                        'created_at' => new \Datetime(),
                        'updated_at' => new \Datetime()
                    ]);

                    continue;
                }

                // nếu đã tồn tại
                $informationGeneralModel->where('slug', $slug)
                    ->update([
                        'content' => $content,
                        'updated_at' => new \Datetime()
                    ]);
            }

        } catch (\Exception $e) {
            Log::error('http->admin->InformationController->generalStore: cập nhật thông tin');
            Error::setErrorMessage('cập nhật thông tin lỗi: dữ liệu nhập vào không hợp lệ.');
        } finally {
            return redirect(route('information-general'));
        }
    }
    
}
