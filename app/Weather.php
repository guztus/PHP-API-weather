<?php declare(strict_types=1);

namespace App;

class Weather
{
    private array $fetchedData;

    public function __construct(array $fetchedData)
    {
        $this->fetchedData = $fetchedData;
    }

    public function getTemperature(): float
    {
        return $this->fetchedData['main']['temp'];
    }

    public function getHumidity(): float
    {
        return $this->fetchedData['main']['humidity'];
    }
}