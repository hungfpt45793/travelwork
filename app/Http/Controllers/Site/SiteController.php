<?php
namespace App\Http\Controllers\Site;

use App\Entity\Domain;
use App\Entity\Information;
use App\Entity\Information_money;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Theme;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Ultility\InforFacebook;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:02 AM
 */
class SiteController extends Controller
{
    public function __construct(){
        $typeInformations = TypeInformation::select(
            'title',
            'slug',
            'type_input',
            'placeholder'
        )
            ->orderBy('type_infor_id')
            ->get();
        // get information
        $informations = Information::select(
            'infor_id',
            'slug_type_input',
            'content'
        )
        ->get();
        $informationShow = array();
        foreach($typeInformations as $id => $typeInformation) {
            $typeInformations[$id]['information'] = '';
            foreach ($informations as $information) {
                if ($information->slug_type_input == $typeInformation->slug) {
                    $informationShow[$typeInformation->slug] = $information->content;
                    break;
                }
            }
        }

        $typeInformations_money = TypeInformation_money::select(
            'type_infor_id',
            'title',
            'slug',
            'type_input',
            'placeholder'
        )
        ->orderBy('type_infor_id')
        ->get();
        // get information
        $informations_money = Information_money::select(
            'infor_id',
            'slug_type_input',
            'content'
        )->get();
        $informationShow_money = array();
        foreach($typeInformations_money as $id => $typeInformation_money) {
            $typeInformations_money[$id]['information'] = '';
            foreach ($informations_money as $information_money) {
                if ($information_money->slug_type_input == $typeInformation_money->slug) {
                    $informationShow_money[$typeInformation_money->slug] = $information_money->content;
                    break;
                }
            }
        }
        $urlLoginFace = $this->getUrlLoginFacebook();
        view()->share([
            'information' => $informationShow,
            'information_money' => $informationShow_money,
            'urlLoginFace' => $urlLoginFace,
            'menuTopsite' => 'menuwebsite',
        ]);
    }


    private function getUrlLoginFacebook () {
        $app = new InforFacebook();

        $fb = new \Facebook\Facebook([
            'app_id' => $app->getAppId(),
            'app_secret' => $app->getAppSecret(),
            'default_graph_version' => $app->getDefaultGraphVersion()
        ]);

        $helper = $fb->getRedirectLoginHelper();


        $permissions = []; // optional
        $loginUrl = $helper->getLoginUrl('http://vn3c.net/callbacklogin', $permissions);

        return $loginUrl;
    }
}
