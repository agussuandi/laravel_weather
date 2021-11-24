<?php

namespace App\Helpers;

use Exception;

class AppHelper
{
    public static function sendRequest($url, $method, $header, $data = null)
    {
        $headers = [
            "content-type: application/json"
        ];

        if ($header != '' || !empty($header)) {
            $headers = array_merge($headers, $header);
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ['response' => $response, 'error_curl' => $err];
    }

    public static function getWeather($lat, $lon)
    {
        $baseUrl = env('API_KEY_BASE_URL');
        $apiKey  = env('API_KEY_WEATHER');
        $url = "{$baseUrl}/data/2.5/onecall?lat={$lat}&lon={$lon}&appid={$apiKey}";

        return self::sendRequest($url, 'GET', '');
    }
}