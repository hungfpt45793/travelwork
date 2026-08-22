<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 2/27/2018
 * Time: 1:54 PM
 */

namespace App\Ultility;


class Error
{
    public static function setErrorMessage($string) {
        session(['errorMessage' => $string]);
    }

    public static function getErrorMessage() {
        $message = session('errorMessage', '');
        session(['errorMessage' => '']);

        return $message;
    }
}