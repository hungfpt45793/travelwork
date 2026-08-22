<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Course\Course;
use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer;
use App\Entity\EmployerIntership;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\Job_sale_money;
use App\Entity\Job_sale_statistical;
use App\Entity\JobFacebook;
use App\Entity\JobFacebookWarning;
use App\Entity\JobGroup;
use App\Entity\Order;
use App\Entity\Post;
use App\Entity\Post_sale_money;
use App\Entity\Post_sale_statistical;
use App\Entity\Salary;
use App\Entity\SettingGetfly;
use App\Entity\Statistical_employees;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_job_group;
use App\Entity\Teacher_save_job_facebook;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\District;
use App\Entity\Workplace;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Transaction\List_product;
use App\Transaction\Money_month_pay;
use App\Transaction\Transaction_history_bank;
use App\Transaction\Transaction_history_card;
use App\Transaction\Transaction_history_product;
use App\Ultility\CallApi;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Prophecy\Call\Call;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\URL;
use function Sodium\compare;


class Employee_saleController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }



}
