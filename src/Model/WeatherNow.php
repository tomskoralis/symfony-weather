<?php

namespace App\Model;

use Cmfcmf\OpenWeatherMap\CurrentWeather;

class WeatherNow
{
    private CurrentWeather $weatherData;

    public function __construct(CurrentWeather $weatherData)
    {
        $this->weatherData = $weatherData;
    }

    public function getLocation(): string
    {
        return $this->weatherData->city->name;
    }

    public function getCountry(): string
    {
        return $this->weatherData->city->country;
    }

    public function getTimeZone(): string
    {
        return $this->weatherData->city->timezone->getName();
    }

    public function getTime(): string
    {
        return $this->weatherData->lastUpdate->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("G:i:s j/m/Y");
    }

    public function getTemperature(): string
    {
        return $this->weatherData->temperature->getFormatted();
    }

    public function getTemperatureMin(): string
    {
        return $this->weatherData->temperature->min->getFormatted();
    }

    public function getTemperatureMax(): string
    {
        return $this->weatherData->temperature->max->getFormatted();
    }

    public function getHumidity(): string
    {
        return $this->weatherData->humidity->getFormatted();
    }

    public function getWindSpeed(): string
    {
        return $this->weatherData->wind->speed->getFormatted();
    }

    public function getWindDirection(): string
    {
        return $this->weatherData->wind->direction->getUnit();
    }

    public function getWeather(): string
    {
        return $this->weatherData->weather->description;
    }

    public function getWeatherSymbol(): string
    {
        return $this->weatherData->weather->icon;
    }

    public function getPrecipitation(): string
    {
        return $this->weatherData->precipitation->getDescription();
    }
}