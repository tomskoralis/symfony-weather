<?php

namespace App\Message;

final class CurrentWeatherMessage
{
    private string $location;
    private string $units;

    public function __construct(string $location, string $units = 'metric')
    {
        $this->location = $location;
        $this->units = $units;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getUnits(): string
    {
        return $this->units;
    }
}
