<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Support\Facades\Log;

class APIgoogle extends Controller
{
    public static function APIgoogle($type, $slug)
    {
        if (!config('services.google_indexing.enabled')) {
            return null;
        }

        $credentials = config('services.google_indexing.credentials');
        if (empty($credentials) || !is_file($credentials)) {
            Log::warning('Google Indexing API is enabled but its credentials file does not exist.', [
                'credentials' => $credentials,
            ]);

            return null;
        }

        if (!in_array($type, ['URL_UPDATED', 'URL_DELETED'], true) || empty($slug)) {
            Log::warning('Google Indexing API notification was skipped because its payload is invalid.');

            return null;
        }

        try {
            $client = new Google_Client();
            $client->setAuthConfig($credentials);
            $client->addScope('https://www.googleapis.com/auth/indexing');

            $response = $client->authorize()->post(
                'https://indexing.googleapis.com/v3/urlNotifications:publish',
                [
                    'json' => [
                        'url' => $slug,
                        'type' => $type,
                    ],
                    'timeout' => 10,
                ]
            );

            return (string) $response->getBody();
        } catch (\Throwable $exception) {
            Log::warning('Google Indexing API notification failed; the main operation will continue.', [
                'message' => $exception->getMessage(),
                'url' => $slug,
            ]);

            return null;
        }
    }
}
