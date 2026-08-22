<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/9/2017
 * Time: 3:00 PM
 */

namespace App\Ultility;


class InforFacebook
{
     private $appId = '1875296572729968';
     private $appSecret = '7508de1a1f33d0cb7581fd56e1a9dee4';
     private $defaultGraphVersion = 'v2.9';

     public function getAppId() {
         return $this->appId;
     }

    public function getAppSecret() {
        return $this->appSecret;
    }

    public function getDefaultGraphVersion() {
        return $this->defaultGraphVersion;
    }
}
