<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/6/2018
 * Time: 6:52 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\LaborExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class LaborExportController  extends Controller
{
    public function index() {


        return view('vn3c.template.labor_export_1');
    }

    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('/xuat-khau-lao-dong-nhat-ban/dang-ky-xuat-khau-lao-dong-nhat-ban')
                ->withErrors($validation)
                ->withInput();
        }

        $idLabor = $this->insertCustomer($request);

        $success = 1;
        return view('vn3c.template.labor_export_1', compact('success', 'idLabor') );

    }

    private function insertCustomer($request) {
        try {
            $laborExport = new LaborExport();
            $id = $laborExport->insertGetId([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
             return $id;
        } catch (\Exception $e) {
            $success = 0;

            return 0;
        }
    }
}