<!--                    -->
{{--@if(isset($job->views) && $job->views == 1)--}}
{{--<?php--}}
{{--require_once '../google-api-php-client-2.4.0_PHP54/vendor/autoload.php';--}}

{{--$client = new Google_Client();--}}

{{--// service_account_file.json is the private key that you created for your service account.--}}
{{--$client->setAuthConfig('../psyched-thunder-268307-31f8c8acebbc.json');--}}
{{--$client->addScope('https://www.googleapis.com/auth/indexing');--}}

{{--// Get a Guzzle HTTP Client--}}
{{--$httpClient = $client->authorize();--}}
{{--$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';--}}

{{--// Define contents here. The structure of the content is described in the next step.--}}

{{--//                    nếu ngày hiện tại lớn hơn ngày nộp hồ sơ thì xóa--}}
{{--if (strtotime($today) > strtotime($date_end)) {--}}
{{--$content = '{--}}
{{--"url": "{{ \App\Ultility\Ultility::getUrl() }}",--}}
{{--"type": "URL_DELETED"--}}
{{--}';--}}
{{--} else {--}}
{{--$content = '{--}}
{{--"url": "{{ \App\Ultility\Ultility::getUrl() }}",--}}
{{--"type": "URL_UPDATED"--}}
{{--}';--}}
{{--}--}}

{{--$response = $httpClient->post($endpoint, ['body' => $content]);--}}
{{--$status_code = $response->getStatusCode();--}}
{{--?>--}}
{{--@endif--}}