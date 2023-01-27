<?php

namespace App\Message;

final class WeatherMessage
{
    private string $location;
    private string $units;
    private ?int $days;

    public function __construct(string $location, string $units = 'metric', ?int $days = 5)
    {
        $this->location = $location;
        $this->units = $units;
        $this->days = $days;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getUnits(): string
    {
        return $this->units;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }
}
