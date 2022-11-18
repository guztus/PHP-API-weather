<?php declare(strict_types=1);

use Carbon\Carbon;

require_once "vendor/autoload.php";
use App\ApiConnection;
use App\City;
use App\Weather;

$APIKEY = ''; // Enter your API key here

$city =(string) readline('Enter a city: ');
$selectedMode =(int) readline("[1] for current weather \n [2] weather for 6 days ");


$cityCoordinates = new City(ApiConnection::setConnection("http://api.openweathermap.org/geo/1.0/direct?q={$city}&limit=1&appid={$APIKEY}"));

switch ($selectedMode) {
    case 1:
        $weather = new Weather(ApiConnection::setConnection("https://api.openweathermap.org/data/2.5/weather?lat={$cityCoordinates->getLatitude()}&lon={$cityCoordinates->getLongitude()}&appid={$APIKEY}&units=metric"));

        echo "In {$city}, the temperature is now {$weather->getTemperature()}°C and humidity is at {$weather->getHumidity()}%" . PHP_EOL;
        break;
    case 2:
        echo "-----------------------------------" . PHP_EOL;
        echo "Day   Time   Temperature   Humidity" . PHP_EOL;
        echo "-----------------------------------" . PHP_EOL;

        $weatherForMultipleDays = (ApiConnection::setConnection("http://api.openweathermap.org/data/2.5/forecast?lat={$cityCoordinates->getLatitude()}&lon={$cityCoordinates->getLongitude()}&appid={$APIKEY}&units=metric"));

        foreach($weatherForMultipleDays['list'] as $nextThreeHours) {
            $weather = new Weather($nextThreeHours);

            $unixCode = $nextThreeHours['dt'];

            $day = Carbon::parse($unixCode)->toDateTime()->format('D');
            $hour = Carbon::parse($unixCode)->toDateTime()->format('H');
            if ($hour == 00) {
                echo "-----------------------------------" . PHP_EOL;
                echo "Day   Time   Temperature   Humidity" . PHP_EOL;
                echo "-----------------------------------" . PHP_EOL;
            }

            $spacesNeeded = 8 - strlen((string)$weather->getTemperature());

            echo "{$day}    {$hour}     {$weather->getTemperature()}°C" . str_repeat(' ', $spacesNeeded) . "     {$weather->getHumidity()}% " . PHP_EOL;
        }
        break;
    default:
        echo "Enter a number from the selection!" . PHP_EOL;
}
