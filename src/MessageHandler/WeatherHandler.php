<?php

namespace App\MessageHandler;

use App\Message\WeatherMessage;
use App\Model\Weather;
use Cmfcmf\OpenWeatherMap;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WeatherHandler
{
    private OpenWeatherMap $openWeatherMap;
    private const TTL = 60;

    public function __construct(ParameterBagInterface $params)
    {
        $this->openWeatherMap = new OpenWeatherMap(
            $params->get('OWM_API_KEY'),
            Client::createWithConfig([]),
            new RequestFactory(),
            new FilesystemAdapter(),
            self::TTL
        );
    }

    public function __invoke(WeatherMessage $sendWeatherMessage): array
    {
        $weatherNow = $this->openWeatherMap->getWeather(
            $sendWeatherMessage->getLocation(),
            $sendWeatherMessage->getUnits()
        );

        $weatherForecast = $this->openWeatherMap->getWeatherForecast(
            $sendWeatherMessage->getLocation(),
            $sendWeatherMessage->getUnits(),
            null,
            null,
            $sendWeatherMessage->getDays()
        );

        $weather = new Weather($weatherNow, $weatherForecast);

        return [
            'location' => $weather->getLocation(),
            'currentTemperature' => $weather->getTemperature(),
            'averageTemperature' => $weather->getAverageTemperature() . ' ' . $weather->getTemperatureUnit(),
            'wind' => $weather->getWindSpeed() . ' from ' . $weather->getWindDirection(),
        ];
    }
}
