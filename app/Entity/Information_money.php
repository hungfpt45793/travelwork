<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 9/24/2017
 * Time: 3:59 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information_money extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'information_money';

    protected $primaryKey = 'infor_id';

    protected $fillable = [
        'infor_id',
        'slug_type_input',
        'content',
        'deleted_at',
        'updated_at'
    ];
    public static function get_information_money()
    {
        $typeInformations = TypeInformation_money::orderBy('type_infor_id')
            ->get();
        // get information
        $informations = Information_money::get();
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
}
