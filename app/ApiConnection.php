<?php declare(strict_types=1);

namespace App;

class ApiConnection
{
    public static function setConnection(string $url): array
    {
        $cityInfo = curl_init();
        curl_setopt($cityInfo, CURLOPT_URL, $url);
        curl_setopt($cityInfo, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cityInfo);

        if ($e = curl_errno($cityInfo)) {
            echo $e;
            exit;
        }
        curl_close($cityInfo);

        return json_decode($response, true);
    }
}