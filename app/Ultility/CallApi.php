<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/20/2017
 * Time: 9:15 AM
 */

namespace App\Ultility;

use App\Entity\SettingGetfly;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CallApi
{
    private $apiKey = '';
    private $baseUrl = '';

    public function __construct() {
        $this->apiKey = SettingGetfly::getApiKey();
        $this->baseUrl = SettingGetfly::getBaseUrl();
    }

    public function getCategory ($queries = null) {
        try {
            // khởi tạo biến truyền lên get
            $query = $this->getQuery($queries);
            if ($query == false) {
                $query = $this->baseUrl. 'products/categories/';
            } else {
                $query = $this->baseUrl. 'products/categories/?'. $query;
            }

            $response = $this->getMethodApi($query);
            $httpCode = $response['httpCode'];

            // dữ liệu lấy về là thành công
            if ($httpCode == 200) {
                $decoded = $response['decode'];

                return $decoded;
            }
            // dữ liệu truyền về không thành công
            return false;
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra trong quá trình tạo đường truyền');

            return false;
        }
    }
    public function getProduct($queries = null) {
        // khởi tạo biến truyền lên get
        $query = $this->getQuery($queries);
        if ($query == false) {
            return false;
        }
        // call api
        $query = $this->baseUrl. 'products/?'. $query;
        $response = $this->getMethodApi($query);
        $httpCode = $response['httpCode'];

        // dữ liệu lấ về là thành công
        if ($httpCode == 200) {
            $decoded = $response['decode'];

            return $decoded;
        }
        // dữ liệu truyền về không thành công
        return false;
    }
    // khởi tạo biến truyền lên get
    private function getQuery($queries) {
        if (empty($queries)) {
            return false;
        }
        // khởi tạo biến truyền lên get
        $query = '';
        foreach ($queries as $key => $value) {
            if ($key == 0) {
                $query .= $key.'='.$value;

                continue;
            }
            $query .= '&'.$key.'='.$value;
        }

        return $query;
    }
    // call api
    private function getMethodApi($query) {
        // truyền dữ liệu lên
        $service_url = $query;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '. $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // kết quả response trả về
        $curl_response = curl_exec($curl);
        if(curl_errno($curl)){      
            echo 'Request Error:' . curl_error($curl);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($curl_response, true);
        curl_close($curl);
        return [
            'httpCode' => $httpCode,
            'decode' => $decoded
        ];
    }
    // post order
    public function postOrder($data) {
        $service_url = $this->baseUrl. 'orders/';
        $curl = curl_init($service_url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '. $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POST, count($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $curl_response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($curl_response, true);
        if($httpcode == 200){
            return true;
        } else {
            return false;
        }
    }

    public function getCampaigns () {
        // truyền dữ liệu lên
        $service_url = $this->baseUrl. '/api/v3/campaigns/';

        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '. $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // kết quả response trả về
        $curl_response = curl_exec($curl);
        if(curl_errno($curl)){
            echo 'Request Error:' . curl_error($curl);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($curl_response, true);
        curl_close($curl);

        return [
            'httpCode' => $httpCode,
            'decode' => $decoded
        ];
    }

    public function addNewCampaign($data) {
        $service_url = $this->baseUrl. '/api/v3/opportunity/';
        $curl = curl_init($service_url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '. $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POST, count($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $curl_response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($curl_response, true);
        if($httpcode == 200){
            return true;
        } else {
            return false;
        }
    }

    public function getCampaignStatus ($campainId) {
        // truyền dữ liệu lên
        $service_url = $this->baseUrl. 'api/v3/campaigns/'.$campainId.'/status';

        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '. $this->apiKey,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // kết quả response trả về
        $curl_response = curl_exec($curl);
        if(curl_errno($curl)){
            echo 'Request Error:' . curl_error($curl);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $decoded = json_decode($curl_response, true);
        curl_close($curl);

        return [
            'httpCode' => $httpCode,
            'decode' => $decoded
        ];
    }

}
