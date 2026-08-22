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

class People
{
    public function upToMe( $postIdOld, $content, $imageUpload, $link, $nameAlbum) {
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

            $accessToken = Auth::user()->accesstoken;

            $response = $fb->get('/me', $accessToken);
            $user = $response->getDecodedBody();
            if (empty($postIdOld)) {
                return $this->postNewMe($accessToken, $user, $content, $imageUpload, $link, $nameAlbum);
            }

            return $this->updatePostMe($accessToken, $postIdOld, $content, $imageUpload, $link);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }
    private function postNewMe($accessToken, $user, $content, $imageUpload, $link, $nameAlbum) {
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

            $content = $content.' source: '.$link;
            $linkData = [
                'message' => $content,
                'name' => $nameAlbum
            ];

            $response = $fb->post($user['id'].'/albums', $linkData, $accessToken);
            $album =  $response->getDecodedBody();
            $images = explode(',', $imageUpload);
            foreach ($images as $image) {
                $fb->post($album['id'].'/photos', [
                    'message' => $content,
                    'url' => asset($image)
                ], $accessToken);
            }
			
            return $album['id'];
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error 1: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error 2: ' . $e->getMessage();
            return null;
        }
    }

    private function updatePostMe($accessToken, $idAlbum, $content, $imageUpload, $link) {
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

            $response = $fb->get($idAlbum.'/photos', $accessToken);
            $photos = $response->getDecodedBody();
            foreach ($photos['data'] as $photo) {
                $fb->delete('/'.$photo['id'],['pid' => $photo['id']], $accessToken);
            }
            $images = explode(',', $imageUpload);
            foreach ($images as $image) {
                $fb->post($idAlbum.'/photos', [
                    'message' => $content.' source: '. $link,
                    'url' => asset($image)
                ], $accessToken);
            }

            return $idAlbum;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }

    public function getInfoUser() {
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
            $response = $fb->get('/me', Auth::user()->accesstoken);

            return $response->getDecodedBody();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return null;
        }
    }
}