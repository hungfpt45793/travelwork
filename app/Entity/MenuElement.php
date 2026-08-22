<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class MenuElement extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'menu_element';

    protected $primaryKey = 'menu_element_id';

    protected $fillable = [
        'menu_element_id',
        'menu_slug',
        'url',
        'title_show',
        'menu_level',
        'menu_image',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function updateMenuElement($menuSlug, $url, $titles, $menuLevels, $menuImages) {
        try {
            $this->where('menu_slug', $menuSlug)
                ->delete();

            foreach($url as $id => $elementSlug) {
                $title = $titles[$id];
                $menuLevel = $menuLevels[$id];
                $menu_image =  $menuImages[$id];

                $this->insert([
                    'url' => $elementSlug,
                    'menu_slug'  => $menuSlug,
                    'title_show' => $title,
                    'menu_level' => $menuLevel,
                    'menu_image' => $menu_image,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Entity->MenuElement');
        }

    }

    public static function callMenuAdmin($menuSlug) {
        try {
            $menuElementModel = new MenuElement();

            $menuElements = $menuElementModel->where('menu_slug', $menuSlug)
                ->orderBy('menu_element_id')->get();
            $countMenu =  $menuElementModel->where('menu_slug', $menuSlug)
                ->count();

            $return = '<ul class="mainMenu" id="sortableListsBase">';
            foreach($menuElements as $id => $element) {
                if ($element->menu_level == 1) {
                    $return .= '<li class="itemMenu">';
                    if ( ( ($id+1) < $countMenu) && ($menuElements[$id + 1]->menu_level > $element->menu_level) ) {
                        $return .= static::showContentMenu($element->title_show, $element->menu_element_id, $element->menu_image, $element->url, $element->menu_level);

                        $return .= '<ol class=" sub' . $element->menu_level . '">[sub_menu' . $element->menu_level . ']</ol>';
                        $return = static::callSubMenuAdmin($menuElements, $countMenu, $return, $element->menu_level, $element->menu_element_id);
                    } else {
                        $return .= static::showContentMenu($element->title_show, $element->menu_element_id, $element->menu_image, $element->url, $element->menu_level);

                    }
                    $return .= '</li>';

                    continue;
                }
            }
            $return .= '</ul>';

            return $return;
        } catch (\Exception $e) {
            Log::error('Entity->MenuElement->callMenuAdmin: Lỗi call menu admin');
            return null;
        }

    }

    private static function callSubMenuAdmin ($menuElements, $countMenu, $return, $menuLevel, $menuElementId) {
        $levelStart = $menuLevel + 1;
        $subMenu = '';
        foreach ($menuElements as $idSub => $elementSub) {
            if ($elementSub->menu_level == $levelStart && ($elementSub->menu_element_id > $menuElementId)) {

                $subMenu .= '<li class="itemMenu">';
                if ( ( ($idSub+1) < $countMenu) && ($menuElements[$idSub + 1]->menu_level > $elementSub->menu_level) ) {
                    $subMenu .= static::showContentMenu($elementSub->title_show, $elementSub->menu_element_id, $elementSub->menu_image, $elementSub->url, $elementSub->menu_level);

                    $subMenu .= '<ol class=" sub' . $elementSub->menu_level . '">[sub_menu' . $elementSub->menu_level . ']</ol>';
                    $subMenu = static::callSubMenuAdmin($menuElements, $countMenu, $subMenu, $elementSub->menu_level, $elementSub->menu_element_id);
                } else {
                    $subMenu .= static::showContentMenu($elementSub->title_show, $elementSub->menu_element_id, $elementSub->menu_image, $elementSub->url, $elementSub->menu_level);
                }
                $subMenu .= '</li>';
            }

            if ($elementSub->menu_level < $levelStart && ($elementSub->menu_element_id > $menuElementId) ) {
                break;
            }
        }

        $return = str_replace('[sub_menu'.($levelStart-1).']', $subMenu, $return);


        return $return;
    }

    public static function showContentMenu($titleShow, $menuElementId, $menuImage, $url, $level) {
        $return = '<div class="mainDiv"><label class="titleShow">'.$titleShow.'</label> 
                    <i class="fa fa-caret-down menuSubButton clickable" data-toggle="collapse" data-target="#menuElement'.$menuElementId.'" aria-expanded="false" aria-controls="menuElement'.$menuElementId.'"></i>';
        $return .= '<div class="collapse" id="menuElement'.$menuElementId.'"><div class="well">
                        <i>Nhãn điều hướng</i>
                         <input type="text" name="title_show[]" value="'.$titleShow.'" class="titleShow form-control clickable" onchange="return changeTitleShowMenu(this);" placeholder="Nhãn điều hướng"/>
                         <i>Đường dẫn hình ảnh</i>
                         <input type="text" name="menu_image[]" class="form-control clickable" value="'.$menuImage.'" placeholder="Đường dẫn hình ảnh"/>
                         <i>Đường dẫn url</i>
                         <input type="text" name="url[]" class="form-control clickable" value="'.$url.'" placeholder="Đường dẫn url"/>
                         <input type="hidden" name=menu_level[] class="menuLevel" value="'.$level.'" placeholder=""/>
                         <p><span class="red clickable" onclick="return removeMenu(this);">Gỡ bỏ</span> | <span class="aqua clickable" data-toggle="collapse" data-target="#menuElement'.$menuElementId.'" aria-expanded="false" aria-controls="menuElement'.$menuElementId.'">Hủy</span></p>
                    </div></div>
                    <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>            
                    </div>';

        return $return;
    }

    public static function showMenuElementPage($menuSlug, $classMenu = '', $isShowIcon = false) {
        try {
            $menuElementModel = new MenuElement();

            $menuElements = $menuElementModel->where('menu_slug', $menuSlug)
               ->orderBy('menu_element_id')->get();
            $countMenu = $menuElementModel->where('menu_slug', $menuSlug)
                ->count();

            $return = '<ul class="mainMenu '.$classMenu.'" id="sortableListsBase">';
            foreach($menuElements as $id => $element) {
                if ($element->menu_level == 1) {
                    $return .= '<li class="itemMenu menu-li hasChild nav-item">';
                    if ( ( ($id+1) < $countMenu) && ($menuElements[$id + 1]->menu_level > $element->menu_level) ) {
                        if (isset($element->menu_image) && !empty($element->menu_image)) {
                            $return .= '<a class="nav-link hvr-overline-from-center" href="'.$element->url.'" data-toggle="dropdown"><img src="'.$element->menu_image.'"  />'.$element->title_show.' <span class="caret"></span></a>';
                        } else {
                            $return .= '<a class="nav-link hvr-overline-from-center" href="'.$element->url.'" data-toggle="dropdown">'.$element->title_show.' <span class="caret"></span></a>';
                        }

                        $return .= '<ul class="dropdown-menu drop-menu dropmenu_item_show_1 submenu sub' . $element->menu_level . '">[sub_menu' . $element->menu_level . ']</ul>';
                        $return = static::callSubMenu($menuElements, $countMenu, $return, $element->menu_level, $element->menu_element_id);
                    } else {
                        if (isset($element->menu_image) && !empty($element->menu_image)) {
                            $return .= '<a class="nav-link hvr-overline-from-center" href="' . $element->url . '" ><img src="' . $element->menu_image . '"  />' . $element->title_show . ' </a>';
                        } else {
                            $return .= '<a class="nav-link hvr-overline-from-center" href="' . $element->url . '" >' . $element->title_show . ' </a>';
                        }
                    }
                    $return .= '</li>';

                    continue;
                }
            }
            $return .= '</ul>';

            return $return;
        } catch (\Exception $e) {
            Log::error('Entity->MenuElement->showMenuElementPage: Lỗi call menu ');

            return null;
        }

    }

    private static function callSubMenu ($menuElements, $countMenu, $return, $menuLevel, $menuElementId) {
        $levelStart = $menuLevel + 1;
        $subMenu = '';
        foreach ($menuElements as $idSub => $elementSub) {
            if ($elementSub->menu_level == $levelStart && ($elementSub->menu_element_id > $menuElementId)) {

                $subMenu .= '<li class="itemMenu menu-hover-li true nav-item">';

                if ( ( ($idSub+1) < $countMenu) && ($menuElements[$idSub + 1]->menu_level > $elementSub->menu_level) ) {
                    if (isset($elementSub->menu_image) && !empty($elementSub->menu_image)) {
                        $subMenu .= '<a class="nav-link hvr-overline-from-center" href="'.$elementSub->url.'" data-toggle="dropdown"><img src="'.$elementSub->menu_image.'" />'.$elementSub->title_show.' <span class="caret"></span></a>';
                    } else {
                        $subMenu .= '<a class="nav-link hvr-overline-from-center" href="'.$elementSub->url.'" data-toggle="dropdown">'.$elementSub->title_show.' <span class="caret"></span></a>';
                    }

                    $subMenu .= '<ul class=" dropdown-menu sub' . $elementSub->menu_level . '">[sub_menu' . $elementSub->menu_level . ']</ul>';
                    $subMenu = static::callSubMenu($menuElements, $countMenu, $subMenu, $elementSub->menu_level, $elementSub->menu_element_id);

                } else {
                    if (isset($elementSub->menu_image) && !empty($elementSub->menu_image)) {
                        $subMenu .= '<a class="nav-link hvr-overline-from-center" href="' . $elementSub->url . '" ><img src="' . $elementSub->menu_image . '"  />' . $elementSub->title_show . ' </a>';
                    } else {
                        $subMenu .= '<a class="nav-link hvr-overline-from-center" href="' . $elementSub->url . '" >' . $elementSub->title_show . ' </a>';
                    }
                }
                $subMenu .= '</li>';
            }

            if ($elementSub->menu_level < $levelStart && ($elementSub->menu_element_id > $menuElementId) ) {
                break;
            }
        }

        $return = str_replace('[sub_menu'.($levelStart-1).']', $subMenu, $return);


        return $return;
    }

    public static function showMenuElementPage2($menuSlug, $objectClassMenu, $isShowIcon = false) {
        $menuElementModel = new MenuElement();

        $menuElements = $menuElementModel->where('menu_slug', $menuSlug)
            ->orderBy('menu_element_id')->get();
        $countMenu =  $menuElementModel->where('menu_slug', $menuSlug)
            ->count();
        $return = '<ul '.(isset($objectClassMenu['ulLevel1']) ? $objectClassMenu['ulLevel1'] : '' ).'>';
        foreach($menuElements as $id => $element) {
            if ($element->menu_level == 1) {
                $return .= '<li '.(isset($objectClassMenu['liLevel1']) ? $objectClassMenu['liLevel1'] : '' ).'>';
                // co con
                if ( ( ($id+1) < $countMenu) && ($menuElements[$id + 1]->menu_level > $element->menu_level) ) {
                    if (isset($element->menu_image) && !empty($element->menu_image) && $isShowIcon == true) {
                        $return .= '<a style="padding-left: 20px;" href="'.$element->url.'" '.(isset($objectClassMenu['aLevel1']) ? $objectClassMenu['aLevel1'] : '' ).'><img src="'.$element->menu_image.'" '.(isset($objectClassMenu['imgLevel1']) ? $objectClassMenu['imgLevel1'] : '' ).' />'.$element->title_show.' <span class="caret"></span></a>';
                    } else {
                        $return .= '<a style="padding-left: 20px;" href="'.$element->url.'" '.(isset($objectClassMenu['aLevel1']) ? $objectClassMenu['aLevel1'] : '' ).' >'.$element->title_show.' <span class="caret"></span></a>';
                    }

                    $return .= '<ul '.(isset($objectClassMenu['ulLevel2']) ? $objectClassMenu['ulLevel2'] : '' ).'>[sub_menu' . $element->menu_level . ']</ul>';
                    $return = static::callSubMenu2($menuElements, $objectClassMenu, $countMenu, $return, $element->menu_level, $element->menu_element_id, $isShowIcon);
                    // menu khong co con
                } else {
                    if (isset($element->menu_image) && !empty($element->menu_image) && $isShowIcon == true) {
                        $return .= '<a style="padding-left: 20px;" href="' . $element->url . '" '.(isset($objectClassMenu['aNotChildLevel1']) ? $objectClassMenu['aNotChildLevel1'] : '' ).'><img src="' . $element->menu_image . '" '.(isset($objectClassMenu['imgLevel1']) ? $objectClassMenu['imgLevel1'] : '' ).' />' . $element->title_show . ' </a>';
                    } else {
                        $return .= '<a style="padding-left: 20px;" href="' . $element->url . '" '.(isset($objectClassMenu['aNotChildLevel1']) ? $objectClassMenu['aNotChildLevel1'] : '' ).' ">' . $element->title_show . ' </a>';
                    }
                }
                $return .= '</li>';

                continue;
            }
        }
        $return .= '</ul>';
        return $return;

    }

    public static function showMenuMainElementPage2($menuSlug, $objectClassMenu, $isShowIcon = false)
    {
        try {
            $menuElementModel = new MenuElement();

            $menuElements = $menuElementModel->where('menu_slug', $menuSlug)->orderBy('menu_element_id')->get();
            $countMenu =   $menuElementModel->where('menu_slug', $menuSlug)->count();

            $return = '<ul '.(isset($objectClassMenu['ulLevel1']) ? $objectClassMenu['ulLevel1'] : '' ).'>';
            foreach($menuElements as $id => $element) {
                if ($element->menu_level == 1) {
                    $return .= '<li '.(isset($objectClassMenu['liLevel1']) ? $objectClassMenu['liLevel1'] : '' ).'>';
                    // co con
                    if ( ( ($id+1) < $countMenu) && ($menuElements[$id + 1]->menu_level > $element->menu_level) ) {
                        if (isset($element->menu_image) && !empty($element->menu_image) && $isShowIcon == true) {
                            $return .= '<a style="padding-left: 20px;" href="'.$element->url.'" '.(isset($objectClassMenu['aLevel1']) ? $objectClassMenu['aLevel1'] : '' ).'>'.$element->title_show.' </a><span class="label_icon no_label" ></span>';
                        } else {
                            $return .= '<a style="padding-left: 20px;" href="'.$element->url.'" '.(isset($objectClassMenu['aLevel1']) ? $objectClassMenu['aLevel1'] : '' ).' >'.$element->title_show.' </a><span class="label_icon no_label" ></span>';
                        }

                        $return .= '<div class="menu_lv_2"><ul '.(isset($objectClassMenu['ulLevel2']) ? $objectClassMenu['ulLevel2'] : '' ).'>[sub_menu' . $element->menu_level . ']</ul></div>';
                        $return = static::callSubMenu2($menuElements, $objectClassMenu, $countMenu, $return, $element->menu_level, $element->menu_element_id);
                        // menu khong co con
                    } else {
                        if (isset($element->menu_image) && !empty($element->menu_image) && $isShowIcon == true) {
                            $return .= '<a href="' . $element->url . '" '.(isset($objectClassMenu['aNotChildLevel1']) ? $objectClassMenu['aNotChildLevel1'] : '' ).'><img src="' . $element->menu_image . '" '.(isset($objectClassMenu['imgLevel1']) ? $objectClassMenu['imgLevel1'] : '' ).' />' . $element->title_show . ' </a>';
                        } else {
                            $return .= '<a href="' . $element->url . '" '.(isset($objectClassMenu['aNotChildLevel1']) ? $objectClassMenu['aNotChildLevel1'] : '' ).' ">' . $element->title_show . ' </a>';
                        }
                    }
                    $return .= '</li>';

                    continue;
                }
            }
            $return .= '</ul>';
            return $return;
        } catch (\Exception $e) {
            echo "lỗi rồi";
        }
    }

    private static function callSubMenu2 ($menuElements, $objectClassMenu, $countMenu, $return, $menuLevel, $menuElementId, $isShowIcon = false) {
        $levelStart = $menuLevel + 1;
        $subMenu = '';
        foreach ($menuElements as $idSub => $elementSub) {
            if ($elementSub->menu_level == $levelStart && ($elementSub->menu_element_id > $menuElementId)) {

                $subMenu .= '<li class="">';
                if ( ( ($idSub+1) < $countMenu) && ($menuElements[$idSub + 1]->menu_level > $elementSub->menu_level) ) {
                    if (isset($elementSub->menu_image) && !empty($elementSub->menu_image) && $isShowIcon == true) {
                        $subMenu .= '<a href="'.$elementSub->url.'" '.(isset($objectClassMenu['aLevel2']) ? $objectClassMenu['aLevel2'] : '' ).' ><img src="'.$elementSub->menu_image.'" '.(isset($objectClassMenu['imgLevel1']) ? $objectClassMenu['imgLevel1'] : '' ).' />'.$elementSub->title_show.' <span class="caret"></span></a>';
                    } else {
                        $subMenu .= '<a href="'.$elementSub->url.'" '.(isset($objectClassMenu['aLevel2']) ? $objectClassMenu['aLevel2'] : '' ).' >'.$elementSub->title_show.' <span class="caret"></span></a>';
                    }

                    $subMenu .= '<ul '.(isset($objectClassMenu['ulLevel2']) ? $objectClassMenu['ulLevel2'] : '' ).'>[sub_menu' . $elementSub->menu_level . ']</ul>';
                    $subMenu = static::callSubMenu2($menuElements, $objectClassMenu, $countMenu, $subMenu, $elementSub->menu_level, $elementSub->menu_element_id);
                } else {
                    if (isset($elementSub->menu_image) && !empty($elementSub->menu_image) && $isShowIcon == true) {
                        $subMenu .= '<a href="' . $elementSub->url . '" class="dropdown-item colorhover" ><img src="' . $elementSub->menu_image . '" '.(isset($objectClassMenu['imgLevel1']) ? $objectClassMenu['imgLevel1'] : '' ).' />' . $elementSub->title_show . ' </a>';
                    } else {
                        $subMenu .= '<a href="' . $elementSub->url . '" class="dropdown-item colorhover" >' . $elementSub->title_show . ' </a>';
                    }
                }
                $subMenu .= '</li>';
            }

            if ($elementSub->menu_level < $levelStart && ($elementSub->menu_element_id > $menuElementId) ) {
                break;
            }
        }

        $return = str_replace('[sub_menu'.($levelStart-1).']', $subMenu, $return);


        return $return;
    }


    public static function showMenuPageArray($menuSlug) {
        try {
            $menuElementModel = new MenuElement();

            $menuElements = $menuElementModel->where('menu_slug', $menuSlug)
                ->orderBy('menu_element_id')->distinct()->get();
            $menuInfor = array();
            foreach($menuElements as $id => $element) {
                if ($element->menu_level == 1) {
                    $subMenu = static::callSubMenuArray2($menuElements, $element->menu_level, $element->menu_element_id);
                    $menuInfor[] = array(
                        'url' => $element->url,
                        'title_show' => $element->title_show,
                        'image' => $element->menu_image,
                        'menu_id' => $element->menu_element_id,
                        'level' => $element->menu_level,
                        'children' => $subMenu
                    );
                }
            }

            return $menuInfor;
        } catch (\Exception $e) {
            echo "lỗi rồi";
        }
    }

    private static function callSubMenuArray2 ($menuElements, $menuLevel, $menuElementId) {
        $levelStart = $menuLevel + 1;
        $menuInfor = array();
        foreach ($menuElements as $idSub => $elementSub) {
            if ($elementSub->menu_level == $levelStart && ($elementSub->menu_element_id > $menuElementId)) {
                $subMenu = static::callSubMenuArray2($menuElements, $elementSub->menu_level, $elementSub->menu_element_id);;
                $menuInfor[] = array(
                    'url' => $elementSub->url,
                    'title_show' => $elementSub->title_show,
                    'image' => $elementSub->menu_image,
                    'menu_id' => $elementSub->menu_element_id,
                    'level' => $elementSub->menu_level,
                    'children' => $subMenu
                );

            }
            if ($elementSub->menu_level < $levelStart && ($elementSub->menu_element_id > $menuElementId) ) {
                break;
            }
        }

        return $menuInfor;
    }

    public static function showMenuElementInfor($menuSlug) {
        try {
            $menuElementModel = new MenuElement();

            $menuElement = $menuElementModel->where('menu_slug', $menuSlug)->orderBy('menu_element_id')
                ->distinct()
                ->get();

            return $menuElement;
        } catch (\Exception $e) {
            Log::error('Entity->MenuElement->showMenuElementInfor: lỗi lấy thông tin menu');
            return null;
        }

    }

    public static function showMenuElement($menuSlug) {
        try {
            $menuElementModel = new MenuElement();

            $menuElement = $menuElementModel->where('menu_slug', $menuSlug)->orderBy('menu_element_id')->get();

            return $menuElement;
        } catch (\Exception $e) {
            Log::error('Entity->MenuElement->showMenuElement: lỗi lấy thông tin menu');
            return null;
        }

    }
}
