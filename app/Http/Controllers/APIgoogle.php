<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
class APIgoogle extends Controller
{
    //
    public static function APIgoogle ($type, $slug)
    {
        // gửi API cho google
        //require_once '/google-api-php-client/vendor/autoload.php';
        $client = new Google_Client();
        
        // service_account_file.json is the private key that you created for your service account.
        $client->setAuthConfig('san-ke-toan-0068b44f1e30.json');
        $client->addScope('https://www.googleapis.com/auth/indexing');

        // Get a Guzzle HTTP Client
        $httpClient = $client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';

        // Define contents here. The structure of the content is described in the next step.
        $content = '{
        "url": "'.$slug.'"
        "type": "'.$type.'"
        }';
        $response = $httpClient->post($endpoint, [ 'body' => $content ]);
        $status_code = $response->getBody();
        // END gửi API cho google
        return $status_code;
    }
}
