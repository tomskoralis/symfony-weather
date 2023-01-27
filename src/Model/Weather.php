<?php

namespace App\Model;

use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Cmfcmf\OpenWeatherMap\WeatherForecast;

class Weather
{
    private CurrentWeather $currentWeather;
    private WeatherForecast $weatherForecast;

    public function __construct(CurrentWeather $currentWeather, WeatherForecast $weatherForecast)
    {
        $this->currentWeather = $currentWeather;
        $this->weatherForecast = $weatherForecast;
    }

    public function getLocation(): string
    {
        return $this->currentWeather->city->name;
    }

    public function getCountry(): string
    {
        return $this->currentWeather->city->country;
    }

    public function getTimeZone(): string
    {
        return $this->currentWeather->city->timezone->getName();
    }

    public function getTime(): string
    {
        return $this->currentWeather->lastUpdate->setTimezone(
            new \DateTimeZone($this->getTimeZone())
        )->format("G:i:s j/m/Y");
    }

    public function getTemperature(): string
    {
        return $this->currentWeather->temperature->getFormatted();
    }

    public function getTemperatureUnit(): string
    {
        return $this->currentWeather->temperature->getUnit();
    }

    public function getTemperatureMin(): string
    {
        return $this->currentWeather->temperature->min->getFormatted();
    }

    public function getTemperatureMax(): string
    {
        return $this->currentWeather->temperature->max->getFormatted();
    }

    public function getHumidity(): string
    {
        return $this->currentWeather->humidity->getFormatted();
    }

    public function getWindSpeed(): string
    {
        return $this->currentWeather->wind->speed->getFormatted();
    }

    public function getWindDirection(): string
    {
        return $this->currentWeather->wind->direction->getUnit();
    }

    public function getWeather(): string
    {
        return $this->currentWeather->weather->description;
    }

    public function getWeatherSymbol(): string
    {
        return $this->currentWeather->weather->icon;
    }

    public function getPrecipitation(): string
    {
        return $this->currentWeather->precipitation->getDescription();
    }

    public function getAverageTemperature(): string
    {
        $total = 0;
        $count = 0;
        $this->weatherForecast->rewind();
        while ($this->weatherForecast->valid()) {
            $total += $this->weatherForecast->current()->temperature->now->getValue();
            $this->weatherForecast->next();
            $count++;
        }
        return (string)round($total / $count, 2);
    }
}