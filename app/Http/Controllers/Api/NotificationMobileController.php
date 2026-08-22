<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Noti_career_category_id;
use App\Entity\Notification_employer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\Entity\User;

class NotificationMobileController extends Controller
{

    public function test_push_api(Request $request)
    {
        //gửi thông báo info den ứng viên
//        $noti_model = new Notification_employer();
//        $link_noti = route('list_Job_Candidate_Employee');
//        $noti_insert =  $noti_model->insert([
//            'title_noti' => 'Sanketoan.vn thông báo',
//            'user_id' => $employer->user_id,
//            'employee_id' => $employee->employee_id,
//            'job_id' => $id_job_fb,
//            'des_noti' => 'Có ứng viên nộp hồ sơ với công việc '.$job->title ,
//            'link_noti' => $link_noti,
//            'type_noti' => 'employer',
//            'created_at' => new \DateTime()
//        ]);
////                    gui api thong bao tren mobile
//        $api_push_noti = new NotificationMobileController();
//        $title = 'Sàn kế toán thông báo';
//        $body = 'Công việc'.$job->title.' trên Sàn kế toán đã có ứng viên ứng tuyển';
//        $type = 'submit_job';
//        $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
//        $value = $employee->employee_id;
//        $to = $employer->user_id;
//        $send_noti = $api_push_noti->pushNotification( $title, $body, $to,$type,$note,$value);

    }
    function post_token(Request $request){
        $args = array();
//        $userId     = $args['user_id'];             //Teacher
//        $token      = $args['token'];
//        $method     = $args['method'];
        $userId     = $request->input('user_id');
        $token      = $request->input('token');
        $method     = $request->input('method');
        if(empty($userId)) return array('success' => false);
        //Get token có sẵn trong user
        $user_model = new User();
//        $content = $GLOBALS['dotb_config']->getOne("SELECT IFNULL(portal_app_token, '') portal_app_token FROM users WHERE id = '$userId'");
        $content = $user_model->select('portal_app_token')->where('id',$userId)->first();
        $content = json_decode(html_entity_decode($content),true);
        $curToken = explode(',', $content['portal_app_token']);
        if(!in_array($token, $curToken) && (empty($method) || $method == 'add')){    //Add Token
            $curToken[] = $token;
            if(!empty($content))
            {
                $string = implode(',',$curToken);
            }
            else
            {
                $string = $token;
            }
            $update_add = $user_model->where('id',$userId)->update([
                'portal_app_token' => $string,
            ]);
            return array(
                'success' => true,
                'noti' => 'thêm token '.$token.' thành công',
            );
        }

        if (($key = array_search($token, $curToken)) && $method == 'delete'){ //remove Token
            unset($curToken[$key]);
            $string = implode(',',$curToken);
            $update_delete = $user_model->where('id',$userId)->update([
                'portal_app_token' => $string,
            ]);
            return array(
                'success' => true,
                'noti' => 'xóa token '.$token.' thành công',
            );
        }
        return array(
            'success' => true,
        );

    }

    public function pushNotification( $title = '', $body = '', $to = '',$type='',$note='',$value=''){
        //FCM_SERVER_KEY a config ở đâu đó. Em sẽ gửi sau.
        //$type 'diendan','job','post'
        //diendan là của skt.sanketoan gồm co cac thoong bao bai viet , binh luan , tang xu, tai tai lieu
        //job gom cac ung vien nop ho so , nha tuyen dung dang tin , duyet tin
        //post gom cac bai viet
        $user_model = new User();
        if(!empty(env('FCM_SERVER_KEY'))){
            // Đối tượng gửi (Nếu to rỗng = gửi tất cả user)
            if(empty($to)){
                $curToken[0] = '/topics/all';
                $to_id = 'all';
            }else{
                $to_id = $to;
                // Get trường portal_app_token ứng với user có id = $to
                $r2  = $user_model->select('portal_app_token')->where('id',$to_id)->first();
                $content = json_decode(html_entity_decode($r2),true);
                $curToken = explode(',', $content['portal_app_token']);
//                return $to_id;
            }
            if(!empty($title)){
                foreach($curToken as $ind => $token){
                    $ch = curl_init();
                    $data = array (
                        'notification' =>
                            array (
                                'title' => $title,
                                'body'  => $body,
                                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            ),
                        'priority' => 'high',
                        'data' =>
                            array (
                                'title' => $title,
                                'body'  => $body,
                                'click_action'  => 'FLUTTER_NOTIFICATION_CLICK',
                                'id'            => '1',
                                'status'        => 'done',
                                // Thêm các trường để chỉ ra nội dung thông báo muốn link tới đối tượng nào để em có thể mở đối tượng đó lên trong app.
                                'type'        => $type,//kiểu thông báo
                                'note'        => $note, //ghi chú nội dung thông báo
                                'value'        => $value, //giá trị thông báo
                                'date_entered'  => date('Y-m-d H:i:s'),
                            ),
                        'to' => $token,
                        'id' => $to_id,
                    );
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: key='.env('FCM_SERVER_KEY');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $err = '';
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $err = 'Error:' . curl_error($ch);
                    }
                    curl_close ($ch);
                }
//                return $result;
                return $data;
            }
        }

    }


    public function testPushNotification( Request $request){

        $title = $request->input('title');
        $body = $request->input('body');
        $to = $request->input('to');
        $type = $request->input('type');
        $note = $request->input('note');
        $value = $request->input('value');


        echo $title.'--';
        echo $body.'--';
        echo $to.'--';
        echo $type.'--';
        echo $note.'--';
        echo $value.'--';

        //FCM_SERVER_KE a config ở đâu đó. Em sẽ gửi sau.
        $user_model = new User();
        if(!empty(env('FCM_SERVER_KEY'))){
            // Đối tượng gửi (Nếu to rỗng = gửi tất cả user)
            if(empty($to)){
                $curToken[0] = '/topics/all';
                $to_id = 'all';
            }else{
                $to_id = $to;
                // Get trường portal_app_token ứng với user có id = $to
                $r2  = $user_model->select('portal_app_token')->where('id',$to_id)->first();
                $content = json_decode(html_entity_decode($r2),true);
                $curToken = explode(',', $content['portal_app_token']);
            }
            if(!empty($title)){
                foreach($curToken as $ind => $token){
                    $ch = curl_init();
                    $data = array (
                        'notification' =>
                            array (
                                'title' => $title,
                                'body'  => $body,
                                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            ),
                        'priority' => 'high',
                        'data' =>
                            array (
                                'title' => $title,
                                'body'  => $body,
                                'click_action'  => 'FLUTTER_NOTIFICATION_CLICK',
                                'id'            => '1',
                                'status'        => 'done',
                                // Thêm các trường để chỉ ra nội dung thông báo muốn link tới đối tượng nào để em có thể mở đối tượng đó lên trong app.
                                'type'        => $type,//kiểu thông báo
                                'note'        => $note, //ghi chú nội dung thông báo
                                'value'        => $value, //giá trị thông báo
                                'date_entered'  => date('Y-m-d H:i:s'),
                            ),
                        'to' => $token,
                    );
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: key='.env('FCM_SERVER_KEY');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $err = '';
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $err = 'Error:' . curl_error($ch);
                    }
                    curl_close ($ch);
                }

                return $data;
            }
        }

    }

}
