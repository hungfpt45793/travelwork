<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/21/2018
 * Time: 11:08 AM
 */

namespace App\Http\Controllers\Admin;

use App\Support\SpreadsheetFile;
use App\Entity\FacebookSetting;
use App\Entity\MemberFacebook;
use App\Entity\FacebookSaveUid;
use Illuminate\Support\Facades\Log;
use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use App\Ultility\InforFacebook;
use Facebook;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class FacebookConvertController extends AdminController
{
    protected $role;
    protected $uids;
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

    public function showConvertFromUid() {
        $countMember = MemberFacebook::where('status', 0)
            ->count();

        return view('admin.facebook.convert_email_phone', compact('countMember'));
    }

    public function getUidFromExcel(Request $request) {

        $this->uids = '';
        foreach (SpreadsheetFile::rows($request->file('file')) as $row) {
            if ($row[0] != 'id' && ! empty($row[0])) {
                $this->uids .= $row[0].'-';
            }
        }

        $this->uids = trim($this->uids, '-');

        $facebookSaveUidExist = FacebookSaveUid::where('status', 0)->first();

        if (empty($facebookSaveUidExist)) {
            FacebookSaveUid::insert([
                'uid_list' => $this->uids,
                'status' => 0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        } else {
            $facebookSaveUidExist->update([
                'uid_list' => $this->uids
            ]);
        }

        $route = $request->input('route');
        // route la 0 thì quay trở lại trang convert email
        if ($route == 0) {
            return redirect(route('show_convert_uid'));
        }
        // route la 1 thi quay tro lai trang tu dong gui ket ban
        return redirect(route('show_request_friend'));
    }

    public function requestFriend(Request $request) {
        $start = $request->input('start');
        $limit = $request->input('limit');


        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        $facebookSaveUids = FacebookSaveUid::where('status', 0)
            ->first();

        if (empty($facebookSaveUids)) {
            return response([
                'status' => 200,
                'success' => 1,
                'delay' => 0,
            ])->header('Content-Type', 'text/plain');
        }

        if (!empty($facebookSaveUids->start) && $start < $facebookSaveUids->start) {
            $start = $facebookSaveUids->start;
        }

        $facebookSaveUids = explode('-', $facebookSaveUids->uid_list);
        if ($start >= count($facebookSaveUids)) {
            FacebookSaveUid::where('status', 0)
                ->update([
                    'status' => 1
                ]);

            return response([
                'status' => 200,
                'success' => 1,
                'delay' => 0,
            ])->header('Content-Type', 'text/plain');

        }

        foreach ($facebookSaveUids as $id => $facebookSaveUid) {
            if ($id >= $start && $id < ($start + $limit)) {
                $isSuccess = $this->requestFriendFacebook($facebookSaveUid, $facebook->accesstoken);
                $isSuccess = json_decode($isSuccess);
                if (isset($isSuccess->error) && $isSuccess->error->code == 525) {
                    FacebookSaveUid::where('status', 0)
                        ->update([
                            'start' => $id
                        ]);
					
                    return response([
                        'status' => 200,
                        'success' => 1,
                        'delay' => 1
                    ])->header('Content-Type', 'text/plain');
                }
            }
        }

        return response([
            'status' => 200,
            'success' => 0,
            'delay' => 0,
            'start' => ($start + $limit),
            'percent' => $start / count($facebookSaveUids) * 100
        ])->header('Content-Type', 'text/plain');
    }

    private function requestFriendFacebook($faceId, $accessToken) {
        $response = Curl::to('https://graph.facebook.com/me/friends/'.$faceId)
            ->withData( array(
                'access_token' => $accessToken,
            ) )
            ->post();

        return $response;
    }

    public function showRequestFriend() {

        return view('admin.facebook.request_friend');
    }

    public function convertFromUid(Request $request) {
        $start = $request->input('start');
        $limit = $request->input('limit');

        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        $facebookSaveUids = FacebookSaveUid::where('status', 0)
            ->first();

        if (empty($facebookSaveUids)) {
            return response([
                'status' => 200,
                'success' => 1,
            ])->header('Content-Type', 'text/plain');
        }

        $facebookSaveUids = explode('-', $facebookSaveUids->uid_list);

        if ($start >= count($facebookSaveUids)) {
            FacebookSaveUid::where('status', 0)
                ->update([
                    'status' => 1
                ]);

            return response([
                'status' => 200,
                'success' => 1,
            ])->header('Content-Type', 'text/plain');

        }

        foreach ($facebookSaveUids as $id => $facebookSaveUid) {
            if ($id >= $start && $id < ($start + $limit)) {
                $this->getInforUser($facebookSaveUid, $facebook->accesstoken);
            }
        }

        return response([
            'status' => 200,
            'success' => 0,
            'percent' => $start / count($facebookSaveUids) * 100
        ])->header('Content-Type', 'text/plain');
    }

    private function getInforUser($memberId, $accessToken) {
        $response = Curl::to('https://graph.facebook.com/'.$memberId.'')
            ->withData( array( 'access_token' => $accessToken ) )
            ->get();

        $member = json_decode($response);
        if (!isset($member->id)
            || ( !isset($member->email) && !isset($member->mobile_phone) )
        ) {
            return null;
        }

        MemberFacebook::insert([
            'uid' => $member->id,
            'name' => $member->first_name.' '.$member->last_name,
            'email' =>  isset($member->email) ? $member->email : '',
            'phone' =>  isset($member->mobile_phone) ? $member->mobile_phone : '',
            'status' => 0
        ]);


    }

}
