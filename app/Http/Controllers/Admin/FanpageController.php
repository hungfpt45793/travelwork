<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/7/2018
 * Time: 1:59 PM
 */

namespace App\Http\Controllers\Admin;

use App\Support\SpreadsheetFile;
use App\Entity\FacebookSetting;
use Illuminate\Support\Facades\Log;
use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use App\Ultility\InforFacebook;
use Facebook;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class FanpageController extends AdminController
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

    public function index() {
        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        // lấy feed mới nhất
        $feeds = array();
        // get group
        $groups = array();
        if (!empty($facebook)) {
            $groups = $this->getGroups($facebook->accesstoken);
            if (!empty($facebook->groups)) {
                foreach (explode(',', $facebook->groups) as $group) {
                    // lấy feed trong group
                    $feeds = $this->getFeeds($facebook->accesstoken, $facebook->like_minimum, $facebook->comment_minimum, $group, $feeds  );
                }
            }
        }


        // lấy thông tin face id đã chọn
        $faceInforByIds = array();
        if (!empty($facebook) && !empty($facebook->face_ids)) {
            foreach (explode(',', $facebook->face_ids) as $faceId) {
                $faceInforByIds[] = $this->getInforFanpage($faceId, $facebook->accesstoken);
                // lấy feed trong face id
                $feeds = $this->getFeeds($facebook->accesstoken, $facebook->like_minimum, $facebook->comment_minimum, $faceId, $feeds  );
            }
        }

        return view('admin.facebook.get_post', compact('groups', 'facebook', 'faceInforByIds', 'feeds'));
    }

    private function getInforFanpage ($faceId, $accessToken = '') {
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = Curl::to('https://graph.facebook.com/'.$faceId)
                ->withData( array( 'access_token' => $accessToken ) )
                ->get();

            $face = json_decode($response);

            return array(
                'id' => $face->id,
                'name' => $face->name
            );
        } catch(\Exception $e) {
			
            echo 'error: ' . $e->getMessage();
            return false;
        }
    }

    private function getGroups($accessToken) {
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = Curl::to('https://graph.facebook.com/me/groups')
                ->withData( array( 'access_token' => $accessToken ) )
                ->get();

           $groups = json_decode($response);

           return $groups->data;

        } catch(\Exception $e) {
            echo 'error: ' . $e->getMessage();
            return array();
        }
    }

    private function getFeeds($accessToken, $commentMinimum, $likesMinimum, $facebookId, $feeds ) {
        try {
            $number = 0;
			// Returns a `Facebook\FacebookResponse` object
            $response = Curl::to('https://graph.facebook.com/'.$facebookId.'/feed')
                ->withData( array( 'access_token' => $accessToken ) )
                ->get();
			
            $response = json_decode($response);
            foreach ($response->data as $feed) {
                if (isset($feed->likes) && $feed->likes->count > $likesMinimum && isset($feed->comments)  && count($feed->comments->data) > $commentMinimum) {
                    // lay hinh anh
					$responseImage = Curl::to('https://graph.facebook.com/'.$feed->id)
                        ->withData( array( 'access_token' => $accessToken,  'fields' => 'full_picture,picture' ) )
                        ->get();

                    $responseImage = json_decode($responseImage);
					// lay thong tin page_id
					$responsePage = Curl::to('https://graph.facebook.com/'.$facebookId)
                        ->withData( array( 'access_token' => $accessToken ) )
                        ->get();

                    $responsePage = json_decode($responsePage);
					
                    $feeds[] = [
                        'id' => $feed->id,
                        'message' => $feed->message,
                        'likes' => $feed->likes->count,
                        'comments' =>  count($feed->comments->data),
                        'object_id' => isset($feed->object_id) ? $feed->object_id : '',
                        'source' => isset($feed->source) ? $feed->source : '',
                        'picture' => isset($responseImage->full_picture) ? $responseImage->full_picture : '',
						'page' => $responsePage
                    ];
					$number ++;
					
					if ($number > 10) {
						break;
					}	
                }
            }

            return $feeds;
        } catch(\Exception $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return array();
        }
    }

    public function updateSetting(Request $request) {
        $accessToken = $request->has('access_token') ? $request->input('access_token') : '';
        $likeMinimum = $request->has('like_minimum') ? $request->input('like_minimum') : 0;
        $commentMinimum = $request->has('comment_minimum') ? $request->input('comment_minimum') : 0;

        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        if (!empty($facebook)) {
            $facebook->update([
                'accesstoken' => $accessToken,
                'like_minimum' => $likeMinimum,
                'comment_minimum' => $commentMinimum
            ]);

            return redirect(route('get_post_facebook'));
        }

        $facebookSettingModel->insert([
            'accesstoken' => $accessToken,
            'like_minimum' => $likeMinimum,
            'comment_minimum' => $commentMinimum,
        ]);

        return redirect(route('get_post_facebook'));
    }

    public function updateGroups (Request $request)
    {
        $groups = $request->has('groups') ? implode(',', $request->input('groups')) : '';

        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        if (empty($facebook)) {
            return redirect(route('get_post_facebook'));
        }

        $facebook->update([
            'groups' => $groups,
        ]);

        return redirect(route('get_post_facebook'));
    }

    public function updateFaceIds (Request $request) {
        $faceId = $request->has('face_id') ? $request->input('face_id') : '';

        if(empty($faceId)) {
            return redirect(route('get_post_facebook'));
        }

        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        if (empty($facebook)) {
            return redirect(route('get_post_facebook'));
        }

        if (!empty($facebook->face_ids)) {
            $faceId = implode(',', [
                $facebook->face_ids,
                $faceId
            ]);
        }

        $facebook->update([
            'face_ids' => $faceId,
        ]);

        return redirect(route('get_post_facebook'));
    }

    public function deleteFaceIds (Request $request) {
        $faceId = $request->has('face_id') ? $request->input('face_id') : '';

        if(empty($faceId)) {
            return redirect(route('get_post_facebook'));
        }

        $facebookSettingModel = new FacebookSetting();
        $facebook = $facebookSettingModel->first();

        if (empty($facebook)) {
            return redirect(route('get_post_facebook'));
        }

        $faceIdNew = array();
        if (!empty($facebook->face_ids)) {
            foreach (explode(',', $facebook->face_ids) as $faceIdOld) {
                if ($faceIdOld != $faceId) {
                    $faceIdNew[] = $faceIdOld;
                }
            }
        }

        $facebook->update([
            'face_ids' => !empty($faceIdNew) ? implode(',', $faceIdNew): ''
        ]);

        return redirect(route('get_post_facebook'));
    }

    public function getInforFacebook() {
        try {
            $facebookSettingModel = new FacebookSetting();
            $facebook = $facebookSettingModel->first();

            $membersFacebooks = array();
            $membersFacebooks[] = array(
                'id',
                'name',
                'email',
                'phone'
            );
            if (!empty($facebook->groups)) {
                foreach (explode(',', $facebook->groups) as $group) {
                    // lấy feed trong group
                    $response = Curl::to('https://graph.facebook.com/'.$group.'/members')
                        ->withData( array(
                            'access_token' => $facebook->accesstoken,
                            'limit' => 300000
                        ) )
                        ->get();

                    $members = json_decode($response);
                    foreach ($members->data as $member) {
                        $membersFacebooks[] = $this->getInforUser($member->id, $facebook->accesstoken);
                    }
                }
            }
        } catch (\Exception $e) {
            echo "lỗi rồi";
        } finally {
            $date = new \DateTime();
            $fileName = "file-thong-tin-".$date->format("d/m/y");
            return SpreadsheetFile::download($membersFacebooks, $fileName);
        }
    }

    private function getInforUser($memberId, $accessToken) {
        $response = Curl::to('https://graph.facebook.com/'.$memberId.'')
            ->withData( array( 'access_token' => $accessToken ) )
            ->get();

        $member = json_decode($response);
        if (!isset($member->id)) {
            return ['', '', '', ''];
        }

        return [
            $member->id,
            $member->first_name.' '.$member->last_name,
            isset( $member->email) ?  $member->email : '',
            isset( $member->mobile_phone) ?  $member->mobile_phone : ''
        ];
    }
}
