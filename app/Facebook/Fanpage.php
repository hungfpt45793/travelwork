<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 4/24/2018
 * Time: 9:17 AM
 */

namespace App\Facebook;


use App\Ultility\InforFacebook;
use Facebook;
use Illuminate\Support\Facades\Auth;

class Fanpage
{
    public function postFanpage($fanpageFacebooks, $content, $imageUpload, $linkFacebook, $nameAlbum) {
        $newInforFanpage = array();

        foreach ($fanpageFacebooks as $fanpage) {
            $token = explode(',', $fanpage);
			if (count($token) < 2) {
				continue;
			}
			
            $pageId = $token[0];
            $accessToken = $token[1];
            $albumId = isset($token[2]) ? $token[2] : null;
            if (!empty($pageId)) {
                if (empty($albumId) || !isset($albumId)) {
                    $albumId = $this->postNewFanpage($pageId, $accessToken, $content, $imageUpload, $linkFacebook, $nameAlbum);
                    $newInforFanpage[] = $pageId . ',' . $accessToken . ',' . $albumId;
                    continue;
                }

                $albumId = $this->updatePostFanapge($accessToken, $albumId, $content, $imageUpload, $linkFacebook);
                $newInforFanpage[] = $pageId . ',' . $accessToken . ',' . $albumId;
            }
        }

        return implode(';', $newInforFanpage);
    }
    private function postNewFanpage ($facePageId, $appAccessToken, $content, $imageUpload, $linkFacebook, $nameAlbum) {
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

            $content = $content.' source: '. $linkFacebook;
            $linkData = [
                'message' => $content,
                'name' =>  $nameAlbum
            ];

            $response = $fb->post($facePageId.'/albums', $linkData, $appAccessToken);
            $album =  $response->getDecodedBody();
            $images = explode(',', $imageUpload);
            foreach ($images as $image) {
                $fb->post($album['id'].'/photos', [
                    'message' => $content,
                    'url' => asset($image)
                ], $appAccessToken);
            }

            return $album['id'];

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }

    private function updatePostFanapge ($appAccessToken, $postId, $content, $imageUpload, $linkFacebook) {
        try {
            if (empty(Auth::user()->accesstoken)) {
                return null;
            }

            $infoFacebook = new InforFacebook();

            $fb = new Facebook\Facebook([
                'app_id' => $infoFacebook->getAppId(),
                'app_secret' => $infoFacebook->getAppSecret(),
                'default_graph_version' => $infoFacebook->getDefaultGraphVersion()
            ]);

            $content = $content.' source: '. $linkFacebook;
            if (!empty($imageUpload)) {
                $response = $fb->get($postId.'/photos', $appAccessToken);
                $photos = $response->getDecodedBody();
                foreach ($photos['data'] as $photo) {
                    $fb->delete('/'.$photo['id'],['pid' => $photo['id']], $appAccessToken);
                }
                $images = explode(',', $imageUpload);
                foreach ($images as $image) {
                    $fb->post($postId.'/photos', [
                        'message' => $content,
                        'url' => asset($image)
                    ], $appAccessToken);
                }

                return $postId;

            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }

    public static function getAllPage() {
        // chưa đăng nhập báo lỗi luôn
        if (!Auth::check()) {
            return null;
        }

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
            $response = $fb->get('/me/accounts', Auth::user()->accesstoken);
            $fanpages = array();
            foreach ($response->getDecodedBody() as $allPages) {
                foreach ($allPages as $page ) {
                    $fanpages[] = $page;
                }
            }

            return $fanpages;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }

    public static function getInforFanpage($fanpagePosts, $fanpageSave) {
        if (!Auth::check()) {
            return null;
        }

        if (empty(Auth::user()->accesstoken)) {
            return null;
        }

        $infoFacebook = new InforFacebook();

        $fb = new Facebook\Facebook([
            'app_id' => $infoFacebook->getAppId(),
            'app_secret' => $infoFacebook->getAppSecret(),
            'default_graph_version' => $infoFacebook->getDefaultGraphVersion()
        ]);

        $accessToken = Auth::user()->accesstoken;

        $informationFanpages = array();
        $response = $fb->get('/me/accounts', $accessToken);
        foreach ($response->getDecodedBody() as $allPages) {
            foreach ($allPages as $page ) {
                if (isset($page['id']) && in_array($page['id'], $fanpagePosts)) { // Suppose you save it as this variable
                    $appAccessToken = (string) $page['access_token'];
                    if (strpos($fanpageSave, $page['id']) === false) {
                        $informationFanpages[] = $page['id'].','.$appAccessToken;
                    }
                }
            }
        }

        return $fanpageSave.';'.implode(';', $informationFanpages);
    }
}