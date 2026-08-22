<?php

namespace App\Ultility;

use App\Category;
use App\Entity\Information_money;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use Carbon\Carbon;

class Infomation
{
    public static function information()
    {
        $typeInformations = TypeInformation::orderBy('type_infor_id')
            ->get();
        // get information
        $informations = Infomation::get();
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
        return $informationShow;
    }
    public static function information_money()
    {
        $typeInformations_money = TypeInformation_money::orderBy('type_infor_id')
            ->get();
        // get information
        $informations_money = Information_money::get();
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
        return $informationShow_money;
    }

}

