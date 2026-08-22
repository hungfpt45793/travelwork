<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/6/2017
 * Time: 2:15 PM
 */

namespace App\Ultility;


class Location
{
      private $locationMenu = array(
          'menu-chinh' => 'menu chính',
          'side-left-menu' => 'sidebar menu trái',
          'footer-first' => 'chân trang thứ 1',
          'footer-second' => 'chân trang thứ 2',
          'footer-third' => 'chân trang thứ 3',
          'menu-footer' => 'menu cuối trang',
          'menu-product' => 'menu sản phẩm',
          'search-product' => 'tìm kiếm sản phẩm',
          'anh-menu' => 'ảnh menu',
          'sider-bar-blog' => 'sidebar blog menu trái',
          'show-category-index' => 'hiển thị danh mục trang chủ vị trí 1',
          'show-category-index2' => 'hiển thị danh mục trang chủ vị trí 2',
          'menu-cate-tab-index' => 'danh mục và tab  menu sản phẩm trang chủ',
          'show-category-new' => 'hiển thị menu tin tức',
          'show-slide-category-new' => 'hiển thị slide tin tức',
      );

      public function getLocationMenu() {
          return $this->locationMenu;
      }
}
