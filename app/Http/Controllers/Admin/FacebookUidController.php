<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/21/2018
 * Time: 10:31 AM
 */

namespace App\Http\Controllers\Admin;

use App\Support\SpreadsheetFile;
use App\Entity\FacebookSetting;
use App\Entity\MemberFacebook;
use Illuminate\Support\Facades\Log;
use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use App\Ultility\InforFacebook;
use Facebook;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class FacebookUidController extends AdminController
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


    public function showGetUid() {
        $countMember = MemberFacebook::where('status', 0)
            ->count();

        return view('admin.facebook.get_uid', compact('countMember'));
    }

    public function getUid(Request $request) {
        $faceId = $request->input('face_id');
        $selectGetId = $request->input('select_get_id'); // 0: lấy từ group_id, 1: lấy từ bài viết, 2: lây danh sách bạn bè

        if (empty($faceId)) {
            return response([
                'status' => 200,
                'success' => 1
            ])
                ->header('Content-Type', 'text/plain');
        }

        // lấy theo group
        if ($selectGetId == 0) {
            $data = $this->getUidGroup($request, $faceId);
            return response($data)
                ->header('Content-Type', 'text/plain');
        }

        // lấy theo feed
        if ($selectGetId == 1) {
            $data = $this->getUidFeed($faceId);
            return response($data)
                ->header('Content-Type', 'text/plain');
        }

        // lấy theo friend list
        if ($selectGetId == 2) {
            $data = $this->getUidFriendList($faceId, $request);
            return response($data)
                ->header('Content-Type', 'text/plain');
        }

        return response([
            'status' => 200,
            'success' => 1
        ])
        ->header('Content-Type', 'text/plain');

    }

    private function getUidGroup($request, $faceId) {
        try {
            $after = $request->input('after');
            $limit = 10000;

            $facebookSettingModel = new FacebookSetting();
             $facebook = $facebookSettingModel->first();

            // lấy feed trong group
            $response = Curl::to('https://graph.facebook.com/'.$faceId.'/members')
                ->withData( array(
                    'access_token' => $facebook->accesstoken,
                    'after' => !empty($after) ? $after : null,
                    'limit' => $limit
                ) )
                ->get();

            $members = json_decode($response);
            foreach ($members->data as $member) {
                MemberFacebook::insert([
                    'uid' => $member->id,
                    'name' => $member->name,
                    'status' => 0
                ]);
            }

            if (isset($members->paging->next)) {
                return [
                    'status' => 200,
                    'success' => 0,
                    'after' => $members->paging->cursors->after,
                ];
            }

            return [
                'status' => 200,
                'success' => 1
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'success' => 1
            ];
        }
    }

    private function getUidFeed($faceId) {
        try {
            $facebookSettingModel = new FacebookSetting();
            $facebook = $facebookSettingModel->first();

            // lấy feed trong face id
            $response = Curl::to('https://graph.facebook.com/'.$faceId.'/feed')
                ->withData( array(
                    'access_token' => $facebook->accesstoken,
                    'limit' => 50
                ) )
                ->get();

            $feeds = json_decode($response);

            foreach ($feeds->data as $feed) {
                var_dump($feed);exit;
                $response = Curl::to('https://graph.facebook.com/'.$feed->id.'/likes')
                    ->withData( array(
                        'access_token' => $facebook->accesstoken,
                        'limit' => 100000
                    ) )
                    ->get();

                $likes = json_decode($response);

                foreach ($likes->data as $memberLike) {
                    MemberFacebook::insert([
                        'uid' => $memberLike->id,
                        'name' => $memberLike->name,
                        'status' => 0
                    ]);

                }
            }

            foreach ($feeds->data as $feed) {
                $response = Curl::to('https://graph.facebook.com/'.$feed->id.'/comments')
                    ->withData( array(
                        'access_token' => $facebook->accesstoken,
                        'limit' => 50
                    ) )
                    ->get();

                $memberComments = json_decode($response);

                foreach ($memberComments->data as $memberComment) {
                    $member = $memberComment->from;
                    MemberFacebook::insert([
                        'uid' => $member->id,
                        'name' => $member->name,
                        'status' => 0
                    ]);
                }
            }

            return [
                'status' => 200,
                'success' => 1
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'success' => 1
            ];
        }
    }

    private function getUidFriendList($faceId, $request) {
        try {
            $after = $request->input('after');

            $facebookSettingModel = new FacebookSetting();
            $facebook = $facebookSettingModel->first();

            // lấy danh sách bạn bè trong face id
            $response = Curl::to('https://graph.facebook.com/'.$faceId.'/friends')
                ->withData( array(
                    'access_token' => $facebook->accesstoken,
                    'after' => !empty($after) ? $after : null,
                    'limit' => 500
                ) )
                ->get();

            $friends = json_decode($response);
            foreach ($friends->data as $member) {
                MemberFacebook::insert([
                    'uid' => $member->id,
                    'name' => $member->name,
                    'status' => 0
                ]);
            }

        if (isset($friends->paging->next)) {
            return [
                'status' => 200,
                'success' => 0,
                'after' => $friends->paging->cursors->after,
            ];
        }

            return [
                'status' => 200,
                'success' => 1
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'success' => 1
            ];
        }
    }

    public function showMembers() {
        $memberFacebookDbs = MemberFacebook::where('user_email', Auth::user()->email)
            ->where('status', 0)
            ->orderBy('member_id')
            ->limit(10000)->get();

        $membersFacebooks = array();
        $membersFacebooks[] = array(
            'id',
            'name',
            'email',
            'phone'
        );

        foreach ($memberFacebookDbs as $member) {
            $membersFacebooks[$member->uid] = [
                $member->uid,
                $member->name,
                $member->email,
                $member->phone
            ];
        }

        MemberFacebook::where('user_email', Auth::user()->email)
            ->where('status', 0)
            ->orderBy('member_id')
            ->limit(10000)
            ->update([
                'status' => 1
            ]);

        $date = new \DateTime();
        $fileName = "uid-".$date->format("d/m/y");
        return SpreadsheetFile::download($membersFacebooks, $fileName);
    }
}
