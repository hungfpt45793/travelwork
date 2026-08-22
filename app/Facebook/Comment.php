<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/2/2018
 * Time: 9:54 AM
 */

namespace App\Facebook;

use App\Ultility\InforFacebook;
use Facebook;
use Illuminate\Support\Facades\Auth;

class Comment
{
    public static function pushComment($faceId) {
        if (empty(Auth::user()->accesstoken)) {
            return null;
        }

        $infoFacebook = new InforFacebook();

        $fb = new Facebook\Facebook([
            'app_id' => $infoFacebook->getAppId(),
            'app_secret' => $infoFacebook->getAppSecret(),
            'default_graph_version' => $infoFacebook->getDefaultGraphVersion()
        ]);

        try {
            $response = $fb->post(
                '/'.$faceId.'/comments',
                array (
                    'message' => 'Tôi thử test comment',
                ),
                Auth::user()->accesstoken
            );
            echo "success";
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}