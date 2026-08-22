<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\Noti_career_category_id;
use App\Entity\Notification;
use App\Entity\Notification_employer;
use App\Entity\Notification_post;
use App\Http\Controllers\Controller;

use Google\Service\ServiceUsage\Http;
use http\Client;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;

use App\Entity\User;

class NotificationEmployerController extends Controller
{
    public function list_noti_employer_job(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không có thông báo mới nào'
                ], 400);
            }
            if ($user->role == 1) {
                $list_noti = $this->list_employees('employee', $user->id, $request);
                return response()->json([
                    'status' => 200,
                    'message' => 'Danh sách thông báo của ứng viên',
                    'list_noti' => $list_noti,
                ], 200);
            }
            if ($user->role == 2) {
                $list_noti = $this->list_employees('employer', $user->id, $request);
                return response()->json([
                    'status' => 200,
                    'message' => 'Danh sách thông báo của nhà tuyển dụng',
                    'list_noti' => $list_noti,
                ], 200);
            }
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Không có thông báo mới nào'
            ], 400);
        }
    }

    public function list_employees($type, $user_id, $request)
    {
        $noti_employer_model = new Notification_employer();
        $list_noti = $noti_employer_model->select(
            'notification_employer.title_noti', //tiêu đề thông báo
            'notification_employer.user_id', //	0 là thông báo chung
            'notification_employer.des_noti', //Nội dung thông báo
            'notification_employer.link_noti', //Link thông báo trên window
            'notification_employer.type_noti', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
            'notification_employer.noti_status', //trạng thái thông báo 0 là chưa xem 1 đã xem
            'notification_employer.view_noti', //Đã hiển thị thông báo ở cửa sơ window
            'notification_employer.job_id', //Đã hiển thị thông báo ở cửa sơ window
            'notification_employer.employee_id', //dung cho trường hợp type_noti = detail_employee
            'notification_employer.created_at',
            'notification_employer.updated_at',
            'jobs.slug', //Đã hiển thị thông báo ở cửa sơ window
            'jobs.title'
        )
            ->join('jobs', 'jobs.job_id', '=', 'notification_employer.job_id')
//            ->where('notification_employer.type_noti', $type)
            ->where('notification_employer.user_id', $user_id)
            ->orderBy('notification_employer.noti_id', 'desc')
            ->orderBy('notification_employer.noti_status', 'asc')
            ->distinct()
            ->paginate(20);
        foreach ($list_noti as $id => $noti) {
            $noti_mes = 'Chưa xem';
            if (!empty($noti->noti_status)) {
                $noti_mes = 'Đã xem';
            }
            $list_noti[$id]['noti_message'] = $noti_mes;
        }
        return $list_noti;
    }

    public function list_employer($type, $user_id, $request)
    {
        $noti_employer_model = new Notification_employer();
        $list_noti = $noti_employer_model->select('title_noti', //tiêu đề thông báo
            'user_id', //	0 là thông báo chung
            'des_noti', //Nội dung thông báo
            'link_noti', //Link thông báo trên window
            'type_noti', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
            'noti_status', //trạng thái thông báo 0 là chưa xem 1 đã xem
            'view_noti', //Đã hiển thị thông báo ở cửa sơ window
            'job_id', //Đã hiển thị thông báo ở cửa sơ window
            'created_at',
            'updated_at')
            ->where('type_noti', $type)
            ->where('user_id', $user_id)
            ->orderBy('noti_id', 'desc')
            ->orderBy('noti_status', 'asc')
            ->paginate(20);
        //danh sach thong bao cua nha tuyen dung ve công việc
        foreach ($list_noti as $id => $noti) {
            $job = Job::select('title', 'job_id', 'slug')->where('job_id', $noti->job_id)->first();
            if (!empty($job)) {
                $list_noti[$id]['title'] = $job->title;
                $list_noti[$id]['slug'] = $job->slug;
            }
            $noti_mes = 'Chưa xem';
            if (!empty($noti->noti_status)) {
                $noti_mes = 'Đã xem';
            }
            $list_noti[$id]['noti_message'] = $noti_mes;
        }
        return $list_noti;
    }

    public function update_user_noti(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không có thông báo mới nào'
                ], 400);
            }
            $noti_employer_model = new Notification_employer();
            $noti_id = $request->input('noti_id');
            $update_noti = $noti_employer_model->where('noti_id', $noti_id)
                ->where('user_id', $user->id)
                ->update([
                    'noti_status' => 1
                ]);
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông báo thành công',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Không có thông báo mới nào'
            ], 400);
        }
    }

    //luu thoi gian cuoi cung user xem thông báo
    public function user_noti_date(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không có thông báo mới nào'
                ], 400);
            }
            $update_api_user_date = User::where('id', $user->id)->update([
                'api_noti_date' => new \DateTime()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Đã xem thông báo',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Không có thông báo mới nào'
            ], 400);
        }
    }

    //Api check xem có noti mới không : GET -> trả về true fasle. True nếu có noti sau thời gian lần cuối user xem noti.
    public function check_user_noti(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không có thông báo mới nào'
                ], 400);
            }
            $api_noti_date = User::where('id', $user->id)->value('api_noti_date');
//            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            //whereDate
            //check thong bao cho user
            $noti_employer_model = new Notification_employer();
            $check_noti_user = $noti_employer_model->where('user_id', $user->id)->whereDate('created_at', '>', $api_noti_date)->first();
            //check tat ca thông báo
            $noti_post_model = new Notification_post();
            $check_noti_home = $noti_post_model->whereDate('created_at', '>', $api_noti_date)->first();
            if (empty($check_noti_home) || empty($check_noti_user)) {
                return response()->json([
                    'status' => 200,
                    'check_noti' => 0,
                    'message' => 'Không có thông báo mới nào'
                ], 200);
            }
            return response()->json([
                'status' => 200,
                'check_noti' => 1,
                'message' => 'Có thông báo mới nào'
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Không có thông báo mới nào'
            ], 400);
        }
    }

    public function list_noti_job(Request $request)
    {
        try {
            if (!empty($request->token)) {
                $token = $request->input('token');
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 2) {
                    $employer = Employer::select('employer_id',
                        'enterprise_name', 'user_id')
                        ->where('user_id', $user->id)
                        ->first();

                    $noti_employer_model = new Notification_employer();
                    $noti_employer = $noti_employer_model->select('noti_id',
                        'title_noti',
                        'des_noti',
                        'link_noti',
                        'status_noti',
                        'view_noti',
                        'employee_id',
                        'created_at'
                    )
                        ->where('user_id', $user->id);
                    $total = $noti_employer->count();
                    $noti_employer = $noti_employer->get();
                    //update tât cá trạng thái đã thông bao
                    if (!empty($noti_employer) && $total > 0) {
                        foreach ($noti_employer as $noti_e) {
                            $update_noti = $noti_employer_model->where('noti_id', $noti_e->noti_id)->update([
                                'view_noti' => 1
                            ]);
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => 'Có ứng tuyển trên sàn kế toán',
                            'total' => $total,
                            'noti_employer' => $noti_employer,
                            'employer' => $employer,
//                        'user' => $user
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Không có thông báo mới nào',
//                        'user' => $user
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Đây là chức năng thông báo của nhà tuyển dụng',
                    ], 400);
                }
            }
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        }
    }

    public function noti_job(Request $request)
    {

        try {
            if (!empty($request->token)) {
                $token = $request->input('token');
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 2) {
                    $employer = Employer::select('employer_id',
                        'enterprise_name', 'user_id')
                        ->where('user_id', $user->id)
                        ->first();

                    $noti_employer_model = new Notification_employer();
                    $noti_employer = $noti_employer_model->select('noti_id',
                        'title_noti',
                        'des_noti',
                        'link_noti',
                        'status_noti',
                        'view_noti',
                        'employee_id',
                        'created_at'
                    )
                        ->where('user_id', $user->id)
                        ->where('view_noti', '>', 0);
                    $total = $noti_employer->count();
                    $noti_employer = $noti_employer->orderBy('noti_id', 'desc');
                    $noti_employer = $noti_employer->first();

                    if (!empty($noti_employer) && $total > 0) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Có ứng tuyển trên sàn kế toán',
                            'total' => $total,
                            'noti_employer' => $noti_employer,
//                        'user' => $user
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Không có thông báo mới nào',
//                        'user' => $user
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Đây là chức năng thông báo của nhà tuyển dụng',
                    ], 400);
                }
            }
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token đăng nhập',
            ], 400);
        }
    }

    public function update_view_noti($noti_id)
    {
        try {
            $noti_employer_model = new Notification_employer();
            $update_noti = $noti_employer_model->where('noti_id', $noti_id)->update([
                'view_noti' => 1
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật trạng thái thông báo thành công',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Có lỗi xảy ra ! vui lòng thử lại sau',
            ], 400);
        }

    }

    public function delete_noti_job(Request $request)
    {
        try {
            $token = $request->input('token');
            $user = JWTAuth::toUser($token);
//            print_r($user);die();
            if ($user->role == 2) {
                $employer = Employer::select('employer_id',
                    'enterprise_name', 'user_id')
                    ->where('user_id', $user->id)
                    ->first();
                $noti_id = $request->input('noti_id');
                $noti_employer_model = new Notification_employer();
                $delete_noti = $noti_employer_model
                    ->where('noti_id', $noti_id)
                    ->where('user_id', $user->id)
                    ->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Xóa thông báo thành công',
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Đây không phải tài khoản nhà tuyển dụng',
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Xóa thông báo thất bại',
            ], 400);
        }

    }

    public function list_podcast(Request $request)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.buzzsprout.com/api/2176164/episodes.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Token token=11cd74abc6e3806365aa3bd3a7d8eace",
                "cache-control: no-cache",
                "postman-token: 1ddd7081-42f5-534a-a927-d4af26d3ccfb"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
////            var_dump(json_decode($response, true));die;
////                        echo $response;die;
//
//                        print_r(json_decode($response, true));die;
            $noti_post_model = new Notification_post();
            foreach (json_decode($response, true) as $re) {
                $check_id_podcast = $noti_post_model->where('type', 'podcast')->where('id_podcast', $re['id'])->value('id_podcast');

                if ($check_id_podcast != $re['id']) {
                    $insert = $noti_post_model->insertGetId([
                        'noti_title' => $re['title'],
                        'post_id' => 0,
                        'slug' => '',
                        'id_podcast' => $re['id'], // id cua podcast  //url https://www.buzzsprout.com/api/2176164/episodes.json   header : [{"key":"Authorization","value":"Token token=11cd74abc6e3806365aa3bd3a7d8eace","description":""}]
                        'type' => 'podcast', //post la bai viet  ,exam la de thi ,podcast laf id am thanh
                        'created_at' => new \DateTime()
                    ]);
                }
            }

        }

    }
    public function delete_noti()
    {

        $date = date('Y-m-j');
        $newdate = strtotime ( '-2 month' , strtotime ( $date ) ) ;
        $newdate_month = date ( 'm' , $newdate );
        $newdate_year  = date ( 'Y' , $newdate );

//        echo $newdate;die;

        $noti_post_model = new Notification_post();
        $list_noti_2_month = $noti_post_model->whereMonth('created_at', '<=',$newdate_month)
            ->whereYear('created_at', '<=',$newdate_year)
            ->get();
        return response()->json([
            'status' => 200,
            'list_noti_2_month' => $list_noti_2_month,
        ], 200);
    }
}
