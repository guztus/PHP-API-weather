<?php

$city = readline('Enter a city: ');

$APIKEY = '';

$cityInfo = curl_init();
curl_setopt($cityInfo, CURLOPT_URL, "http://api.openweathermap.org/geo/1.0/direct?q={$city}&limit=1&appid={$APIKEY}");
curl_setopt($cityInfo, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($cityInfo);

if ($e = curl_errno($cityInfo)) {
    echo $e;
    exit;
}

$decodedCountryData = json_decode($response, true);

if (count($decodedCountryData) == 0) {
    echo "Could not find such country!" . PHP_EOL;
    exit;
}

curl_close($cityInfo);

$cityLatitude = $decodedCountryData[0]['lat'];
$cityLongitude = $decodedCountryData[0]['lon'];

// // // // // //

$weatherData = curl_init();
curl_setopt($weatherData, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?lat={$cityLatitude}&lon={$cityLongitude}&appid={$APIKEY}&units=metric");
curl_setopt($weatherData, CURLOPT_RETURNTRANSFER, true);
$weatherResponse = curl_exec($weatherData);

if ($e = curl_errno($weatherData)) {
    echo $e;
    exit;
} else {
    $decoded = json_decode($weatherResponse, true);
}
curl_close($weatherData);


$temperature = $decoded['main']['temp'];
$humidity = $decoded['main']['humidity'];

echo "In {$city}, the temperature is now {$temperature}°C and humidity is at {$humidity}%" . PHP_EOL;