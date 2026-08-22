<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Menu extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_id',
        'title',
        'slug',
        'location',
        'image',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public static function showTitleMenu($slug) {
        try {
            $menuModel = new Menu();

            $menu = $menuModel->where('slug', $slug)
               ->first();


            return $menu->title;
        } catch (\Exception $e) {
            Log::error('Entity->Menu->showTitleMenu: hiển thị tiêu đề menu');

            return null;
        }
    }

    public static function showTitleMenu2($slug) {
        $menuModel = new Menu();

        $menu = $menuModel->where('slug', $slug)->first();

        return $menu->title;
    }

    public static function showWithLocation($slug) {
        try {
          //  $menuModel = new Menu();

            $menus = static::orderBy('menu_id')->where('location', $slug)
                ->get();

            return $menus;
        } catch(\Exception $e) {
            Log::error('Entity->Menu->showWithLocation: hiển thị vị trí menu');

            return array();
        }
    }

}
