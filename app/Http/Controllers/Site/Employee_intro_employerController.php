<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Cv_employee;
use App\Entity\Cv_experience;
use App\Entity\Employee_intro_employer;
use App\Entity\Employee_specialize;
use App\Entity\Employee_experience;
use App\Entity\Cv_info;
use App\Entity\Cv_note_template;
use App\Entity\Cv_project;
use App\Entity\Cv_skills;
use App\Entity\Cv_specialize;
use App\Entity\Cv_template;
use App\Entity\Cv_work;
use App\Entity\Employee;
use App\Entity\Employee_curriculum;
use App\Entity\Employee_curriculum_extend;
use App\Entity\Employee_follow_employer;
use App\Entity\Employer;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\NotificationWindow;
use App\Entity\Order;
use App\Entity\Invite;
use App\Entity\SettingGetfly;
use App\Entity\Template_email;
use App\Entity\User;
use App\Entity\Workplace;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Entity\MailConfig;
use App\Ultility\Error;
use Illuminate\View\View;
use Prophecy\Call\Call;
use App\Entity\Software;
use App\Entity\Career;
use App\Entity\Salary;
use PDF;

class Employee_intro_employerController extends SiteController
{
    public function list_intro_employer(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('mesage_modal', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        $employee_intro_employer = new Employee_intro_employer();
        $list_employer_intro = $employee_intro_employer->select('employee_intro_employer.user_id',
            'employee_intro_employer.employer_id',
            'employee_intro_employer.status_intro',
            'employee_intro_employer.money_status',
            'employee_intro_employer.created_at',
            'employer.enterprise_name',
            'employer.email'
        )->join('employer','employer.employer_id','=','employee_intro_employer.employer_id')
            ->get();

//        echo '<pre>';
//        print_r($list_employer_intro);

        return view('site.employee_site.list_intro_employer', compact('list_employer_intro'));

    }

}