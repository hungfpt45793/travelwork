<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_type_information_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'coin_type_information_employer';
    protected $primaryKey = 'type_infor_id';
    protected $fillable = [
        'title',
        'slug',
        'type_input',
        'placeholder',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function get_coin_info()
    {
        $typeInformations = Coin_type_information_employer::orderBy('type_infor_id')
            ->get();
        // get information
        $informations = Coin_information_employer::get();
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
