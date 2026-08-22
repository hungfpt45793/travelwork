<?php

namespace App\Http\Controllers\Site;

use App\Entity\Cv_employee;
use App\Entity\Employee;
use App\Entity\Cv_template;
use App\Entity\Cv_note_template;
use App\Entity\Employee_curriculum;
use App\Entity\Employee_follow_employer;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\NotificationWindow;
use App\Entity\Invite;
use App\Entity\SettingGetfly;
use App\Entity\Template_email;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Error;
use Illuminate\View\View;
use App\Entity\Salary;
use Illuminate\Support\Facades\Storage;
use PDF;
use PDFMerger;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use App\Entity\Service_price;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_time;

class PdfController extends SiteController
{
    public function pdf_list_price($id)
    {
        $list_price = Service_price::where('service_price_type', 0)->where('service_price_id', $id)->first();
        $dompdf = PDF::loadView('site.default.pdf.pdf_list_price', compact(
            'list_price'
        ))->setPaper('a4');
        return $dompdf->stream('Bảng báo giá dịch vụ ' . $list_price->service_price_title . '.pdf');
    }

    public function pdf_list_price_hunter($id)
    {
        $list_price_hunter = Service_price::where('service_price_type', 2)->where('service_price_id', $id)->first();
        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $dompdf = PDF::loadView('site.default.pdf.pdf_list_price_hunter', compact(
            'list_price_hunter',
            'hunters_pos',
            'hunters_time'
        ))->setPaper('a4');
        return $dompdf->stream('Bảng báo giá dịch vụ ' . $list_price_hunter->service_price_title . '.pdf');
    }

    public function exportpdf_cv_user_id($user_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $career_category_name = '';
        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        if (!empty($list_career)) {
            foreach ($list_career as $id => $career) {
                if ($id == 0) {
                    $career_category_name = $career->career_category_name;
                } else {
                    $career_category_name .= ' | ' . $career->career_category_name;
                }
            }
        }

        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));
        $dompdf = PDF::loadView('site.employee.cv', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'list_career'))->setPaper('a4');
        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);
    }

    public function self_exportpdf_cv_user_id($user_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $career_category_name = '';
        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        if (!empty($list_career)) {
            foreach ($list_career as $id => $career) {
                if ($id == 0) {
                    $career_category_name = $career->career_category_name;
                } else {
                    $career_category_name .= ' | ' . $career->career_category_name;
                }
            }
        }

        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));

        $dompdf = PDF::loadView('site.employee.cv0', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'user_id'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'list_career'))->setPaper('a4');

        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);
    }

    public function employer_exportpdf_cv_user_id($user_id ,Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();

        $career_category_name = '';
        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        if (!empty($list_career)) {
            foreach ($list_career as $id => $career) {
                if ($id == 0) {
                    $career_category_name = $career->career_category_name;
                } else {
                    $career_category_name .= ' | ' . $career->career_category_name;
                }
            }
        }
        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));
        $employer_id = !empty($request->input('employer_id')) ? $request->input('employer_id') : '0';
        $dompdf = PDF::loadView('site.employee.cv1', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee','employer_id'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'list_career'))->setPaper('a4');
        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


// gop
        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);
    }
    //show hết thông tin ứng viên trong app phan show full thông tin
    public function employer_exportpdf_cv_user_id_full($user_id ,Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();

        $career_category_name = '';
        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        if (!empty($list_career)) {
            foreach ($list_career as $id => $career) {
                if ($id == 0) {
                    $career_category_name = $career->career_category_name;
                } else {
                    $career_category_name .= ' | ' . $career->career_category_name;
                }
            }
        }
        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));
        $employer_id = !empty($request->input('employer_id')) ? $request->input('employer_id') : '0';
        $dompdf = PDF::loadView('site.employee.cv1_full', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee','employer_id'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'list_career'))->setPaper('a4');
        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


// gop
        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);
    }


    public function exportpdf_cv(Request $request)
    {

        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $user_id = Auth::user()->id;
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $career_category_name = '';
        $list_career = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        if (!empty($list_career)) {
            foreach ($list_career as $id => $career) {
                if ($id == 0) {
                    $career_category_name = $career->career_category_name;
                } else {
                    $career_category_name .= ' | ' . $career->career_category_name;
                }
            }
        }

        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));
        $dompdf = PDF::loadView('site.employee.cv', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'list_career'))->setPaper('a4');
        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


// gop
        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);


    }
    public function employer_exportpdf_cv(Request $request, $employee_id)
    {
        if (Auth::check() && Auth::user()->role != 2) {
            return redirect()->back()->with('error_export', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng');
        }
        $employer = \App\Entity\Employer::getIdUser(Auth::user()->id);
        $check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (empty($check_contact_employee)) {
            return redirect()->back()->with('error_export', 'Bạn phải xem thông tin liên hệ thì mới tải được CV');
        }
        $employee_get = \App\Entity\Employee::getIdEmployee($employee_id);
        if (empty($employee_get)) {
            return redirect()->back()->with('error_export', 'Ứng viên này không tồn tại');
        }
        $user_id = $employee_get->user_id;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();


        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        // return view('site.employee.cv',compact('employee','cv_template','cv_note_template','cv_employee'));
        $dompdf = PDF::loadView('site.employee.cv', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee'))->setPaper('a4');
        $dompdf2 = PDF::loadView('site.employee.cv2', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee'))->setPaper('a4');
        $dompdf3 = PDF::loadView('site.employee.cv3')->setPaper('a4');
        PDF::setOptions(['dpi' => 150]);
        // $pdf->download();
        // return $dompdf->stream();
        $dompdf->save(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $dompdf2->save(public_path() . '/CV/b' . $employee->employee_id . '.pdf');
        $dompdf3->save(public_path() . '/CV/c' . $employee->employee_id . '.pdf');

        // $content = $dompdf->download()->getOriginalContent();
        // Storage::put('public/pdf/invoice.pdf', $content);


// gop
        $pdf = new FPDI();
        $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        $pageCount1 = $pdf->setSourceFile(public_path() . '/CV/a' . $employee->employee_id . '.pdf');
        for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
            $backId[$pageNo1] = $pdf->importPage($pageNo1);
        }
        $pageCount3 = $pdf->setSourceFile(public_path() . '/CV/c' . $employee->employee_id . '.pdf');
        $pageId3 = $pdf->importPage($pageCount3);
        $pageCount = $pdf->setSourceFile(public_path() . '/CV/b' . $employee->employee_id . '.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            if (isset($backId[$pageNo])) {
                $pdf->useTemplate($backId[$pageNo]);
            }
            $pageId = $pdf->importPage($pageNo);
            $pdf->useTemplate($pageId3);
            $pdf->useTemplate($pageId);
        }
        if ($pageCount1 > $pageCount) {
            for ($pageNo = $pageCount + 1; $pageNo <= $pageCount1; $pageNo++) {
                $pdf->AddPage();
                $pdf->useTemplate($backId[$pageNo]);
                $pdf->useTemplate($pageId3);
            }
        }
        $slug_name = Str::slug($cv_employee->cv_name, '_');
        $nameout = $pdf->SetTitle('CV_' . $slug_name . '.pdf');
        //$pdf->Output('I', 'CV_' . $slug_name);
        $pdf->Output($slug_name . '.pdf', 'I');
        $myFile = public_path() . '/CV/b' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/a' . $employee->employee_id . '.pdf';
        File::delete($myFile);
        $myFile = public_path() . '/CV/c' . $employee->employee_id . '.pdf';
        File::delete($myFile);


    }
//    public function exportpdf_so_yeu_ly_lich(Request $request)
//    {
////        $pdf = App::make('dompdf.wrapper');
////        $pdf->loadHTML('<h1>Test</h1>');
////            $pdf = PDF::loadView('site.employee.test_cv');
////        return $pdf->stream();
//        if (!Auth::check() || Auth::user()->role != 1) {
//            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
//        }
//        session_start();
//        $ckeditor = new CkedittorController();
//        $session_image = $ckeditor->checkImage();
//        $user_id = Auth::user()->id;
//        $employee = Employee::select('employee_id',
//            'employee_code',
//            'employee_name',
//            'employee_image',
//            'phone',
//            'email',
//            'province',
//            'district',
//            'address',
//            'file_cv',
//            'gender',
//            'birthday',
//            'marry',
//            'school',
//            'majors',
//            'cmt',
//            'cmt_date',
//            'cmt_local',
//            'user_id'
//        )->where('user_id', $user_id)->first();
//        $employee_curriculum = '';
//        $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
//            ->join('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
//            ->where('employee_curriculum.employee_id', $employee->employee_id)
//            ->first();
//        // return view('site.employee.test_cv',compact('employee','employee_curriculum'));
//        $pdf = PDF::loadView('site.employee.test_cv', compact('employee', 'employee_curriculum'))->setPaper('a4');
//        return $pdf->stream(isset($employee_curriculum->hoten) ? str_slug($employee_curriculum->hoten) : str_slug($employee->employee_name) . '_so-yeu-ly-lich.pdf');
//        //return $pdf->download();
//    }



//    public function employer_exportpdf_so_yeu_ly_lich(Request $request, $employee_id)
//    {
//        if (Auth::check() && Auth::user()->role != 2) {
//            return redirect()->back()->with('error_export', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng');
//        }
//        $employer = \App\Entity\Employer::getIdUser(Auth::user()->id);
//        $check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
//        if (empty($check_contact_employee)) {
//            return redirect()->back()->with('error_export', 'Bạn phải xem thông tin liên hệ thì mới tải được sơ yếu lý lịch');
//        }
//        $employee_get = \App\Entity\Employee::getIdEmployee($employee_id);
//        if (empty($employee_get)) {
//            return redirect()->back()->with('error_export', 'Ứng viên này không tồn tại');
//        }
//        $user_id = $employee_get->user_id;
//        session_start();
//        $ckeditor = new CkedittorController();
//        $session_image = $ckeditor->checkImage();
//        $employee = Employee::select('employee_id',
//            'employee_code',
//            'employee_name',
//            'employee_image',
//            'phone',
//            'email',
//            'province',
//            'district',
//            'address',
//            'file_cv',
//            'gender',
//            'birthday',
//            'marry',
//            'school',
//            'majors',
//            'cmt',
//            'cmt_date',
//            'cmt_local',
//            'user_id'
//        )->where('user_id', $user_id)->first();
//        $employee_curriculum = '';
//        $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
//            ->join('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
//            ->where('employee_curriculum.employee_id', $employee->employee_id)
//            ->first();
//        // return view('site.employee.test_cv',compact('employee','employee_curriculum'));
//        $pdf = PDF::loadView('site.employee.test_cv', compact('employee', 'employee_curriculum'))->setPaper('a4');
//        return $pdf->stream(isset($employee_curriculum->hoten) ? str_slug($employee_curriculum->hoten) : str_slug($employee->employee_name) . '_so-yeu-ly-lich.pdf');
//        //return $pdf->download();
//    }
}
