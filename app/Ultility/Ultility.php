<?php

namespace App\Ultility;

use App\Category;
use Carbon\Carbon;

class Ultility
{
    public static function create_random_string($min,$max)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return strtoupper(substr(str_shuffle($permitted_chars), $min, $max));

    }
    public static function createSlug($string, $delimiter = '-')
    {
        try {
            $unicode = array(

                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

                'd' => 'đ',

                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

                'i' => 'í|ì|ỉ|ĩ|ị',

                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

                'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

                'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

                'D' => 'Đ',

                'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

                'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

                'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

                'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

                'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',


            );

            foreach ($unicode as $nonUnicode => $uni) {

                $string = preg_replace("/($uni)/i", $nonUnicode, $string);

            }

            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
            $clean = strtolower(trim($clean, '-'));
            $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        } catch (\Exception $e) {
            return null;
        }

        return strtolower($clean);
    }
    public static function textLimit($str, $limit = 10)
    {
        if (stripos($str, " ")) {
            $str_s = '';
            $ex_str = explode(" ", $str);
            if (count($ex_str) > $limit) {
                for ($i = 0; $i < $limit; $i++) {
                    $str_s .= $ex_str[$i] . " ";
                }
                $str_s .= '...';
                return $str_s;
            }

            return $str;
        }

        return $str;
    }

    public static function repalce_html($str)
    {
        $str = str_replace('&nbsp;', '', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT, 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);

        return $str;
    }

    public static function get_client_ip()
    {
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    public static function getCurrentDomain()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $url = $protocol . $_SERVER['HTTP_HOST'];

        return $url; // Outputs: Full URL
    }

    public static function ReplaceContent($content)
    {
        $content = html_entity_decode($content);
        $content = (str_replace("&lt;", "<", $content));
        $content = (str_replace("&gt;", ">", $content));

        $content = (str_replace("&rsquo;", "'", $content));

        $content = (str_replace("&sbquo;", ",", $content));
        $content = (str_replace("&rdquo;", '"', $content));
        $content = (str_replace("&frasl;", "/", $content));
        $content = (str_replace("&ndash;", "-", $content));

        $content = str_replace('&nbsp;', '', $content);
        $content = (str_replace("&Agrave;", "À", $content));
        $content = (str_replace("&Aacute;", "Á", $content));
        $content = (str_replace("&Acirc;", 'Â', $content));
        $content = (str_replace("&Atilde;", "Ã", $content));
        $content = (str_replace("&Egrave;", "È", $content));
        $content = (str_replace("&Eacute;", "Ê", $content));
        $content = (str_replace("&Igrave;", "Ì", $content));
        $content = (str_replace("&Iacute;", "Í", $content));
        $content = (str_replace("&Icirc;", 'Ĩ', $content));
        $content = (str_replace("&ETH;", "Đ", $content));
        $content = (str_replace("&Ograve;", 'Ò', $content));
        $content = (str_replace("&Oacute;", "Ó", $content));
        $content = (str_replace("&Ocirc;", "Ô", $content));
        $content = (str_replace("&Otilde;", "Õ", $content));
        $content = (str_replace("&Ugrave;", 'Ù', $content));
        $content = (str_replace("&Uacute;", "Ú", $content));
        $content = (str_replace("&Yacute;", 'Ý', $content));
        $content = (str_replace("&agrave;", "à", $content));
        $content = (str_replace("&aacute;", "á", $content));
        $content = (str_replace("&acirc;", 'â', $content));
        $content = (str_replace("&atilde;", "ã", $content));
        $content = (str_replace("&egrave;", "è", $content));
        $content = (str_replace("&eacute;", "ê", $content));
        $content = (str_replace("&igrave;", "ì", $content));
        $content = (str_replace("&iacute;", "í", $content));
        $content = (str_replace("&icirc;", 'ĩ', $content));
        $content = (str_replace("&ograve;", 'ò', $content));
        $content = (str_replace("&oacute;", "ó", $content));
        $content = (str_replace("&ocirc;", "ô", $content));
        $content = (str_replace("&otilde;", "õ", $content));
        $content = (str_replace("&ugrave;", 'ù', $content));
        $content = (str_replace("&uacute;", "ú", $content));
        $content = (str_replace("&yacute;", 'ý', $content));

        return $content;
    }

    public static function getdateFacebook($date)
    {
        $date_facebook = '';
        if (!empty($date)) {
            //lay giờ theo giống facebook
            Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
            $date = date_create($date);
            $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
            $now = Carbon::now();
            $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước
        }
        return $date_facebook;
    }

    public static function getUrl()
    {
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL = "https://";
        } else {
            $pageURL = 'http://';
        }
        if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;

    }

    public static function getMacHome()
    {
        ob_start();
        system('getmac');
        $Content = ob_get_contents();
        ob_clean();
        return substr($Content, strpos($Content, '\\') - 20, 17);
    }

    public static function getMacCline()
    {
        ob_start();
        system('ipconfig/all');
        $mycom = ob_get_contents();
        ob_clean();
        $findme = "Physical";
        $pmac = strpos($mycom, $findme);
        $mac = substr($mycom, ($pmac + 36), 17);

    }

    public static function replace_phone($content)
    {
        $replace_content = preg_replace('/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/', '(*******)', $content);
        return $replace_content;
    }

    public static function parsePageSignedRequest()
    {
        if (isset($_REQUEST['signed_request'])) {
            $encoded_sig = null;
            $payload = null;
            list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
            $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
            $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
            return $data;
        }
        return false;
    }
    public static function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );
        return $output_file;
    }
    //ham loai bo script
    public static function preg_replace_script($content)
    {
//        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $content_html = preg_replace("#<script(.*?)>(.*?)</script>#is", '', $content);
        return $content_html;
    }
}

