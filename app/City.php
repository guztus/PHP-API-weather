<?php declare(strict_types=1);

namespace App;

class City
{
    private array $fetchedData;

    public function __construct(array $fetchedData)
    {
        $this->fetchedData = $fetchedData;
    }

    public function getRawFetchedData(): array
    {
        return $this->fetchedData;
    }

    public function getLatitude(): float
    {
        return $this->fetchedData[0]['lat'];
    }

    public function getLongitude(): float
    {
        return $this->fetchedData[0]['lon'];
    }
}