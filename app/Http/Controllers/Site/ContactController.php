<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/28/2017
 * Time: 10:07 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\EmployeeCareerCategories;
use App\Entity\Employer;
use App\Entity\Input;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Entity\User;
use App\Mail\Mail;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

class ContactController extends SiteController
{
    public function __construct(){
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!Auth::check()) {
            return redirect('/');
        }
    }

    public function index() {

         return view('site.default.contact');
    }

    public function submit(Request $request) {

        $id = Auth::user()->id;
        //success
        $contact = new Contact();
        $contact->insert([
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'user_id' => $id,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $feedback_email = $request->input('email-gop-y');
        $message =  $request->input('message');
        $success = 1;
        $this->sendMainContact($feedback_email ,$request,$message);
        //gửi email cảm ơn đã góp y
        $user = User::select('id','email')->where('id',$id)->first();
        MailConfigController::feedback($user->email);
        return view('site.default.success_contact');
//        Cảm ơn bạn đã góp ý cho chúng tôi, chúng tôi sẽ sớm phản hồi sớm nhất đến bạn !
    }
    private function sendMainContact($feedback_email ,$request,$message)  {
        $subject =  'Có liên hệ mới từ website';
        $content = $message;

        MailConfig::sendMail($feedback_email, $subject, $content);
    }

    private function addNewCampaignGetfly ($request) {
        try {
            $account = (object) [
                "account_name" => $request->input('name'),
                "phone_office" => $request->input('phone'),
                "email" => $request->input('email'),
                "gender" =>  0,
                "billing_address_street" => $request->input('address').' '.$request->input('note'),
                // "birthday" => $request->input('birthday_day').'/'.$request->input('birthday_Month').'/'.$request->input('birthday_Year'),
                "account_type" =>  1,
                "industry" => "2,3"
            ];

            $opportunity = (object) [
                'token_api' => $request->input('campain_getfly'),
                'user_id' => "",
                'recipient' => 0,
                'opportunity_status' => $request->input('campain_status'),

            ];

            $contacts = [
                "first_name" => $request->input('name'),
                "email" => $request->input('email'),
                "phone_mobile" => $request->input('phone')
            ];

            $referer = (object) [
                "utm_source" =>  $request->input('utm_source'),
                "utm_campaign" => $request->input('utm_campaign'),
            ];

            $data = (object) [
                'account' => $account,
                'contacts' => $contacts,
                'opportunity' => $opportunity,
                'referer' => $referer
            ];

            // đồng bộ lên getfly.
            $callApi = new CallApi();
            $callApi->addNewCampaign($data);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // tao moi nha tuyen dung
    private function createNewEmployer ($request) {
        $employerModel = new Employer();
        // thêm mới nhà tuyển dụng

        $employerModel ->insertGetId([
            'enterprise_name' => $request->input('name'),
            'address' => $request->input('address'),
            'introduction' => $request->input('note'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
    }

    // tao moi ứng viên
    private function createNewEmployee ($request) {
        $employeeId = Employee::insertGetId([
            'employee_name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->has('email') ? $request->input('email') : '',
            'information_verifier' => $request->has('note') ? $request->input('note') : '',
            'status' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        if ($request->has('careers') && !empty($request->input('careers'))) {
            foreach($request->input('careers') as $career) {
                EmployeeCareerCategories::insert([
                    'employee_id' => $employeeId,
                    'career_category_id' => $career,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
            }
        }
    }
}
