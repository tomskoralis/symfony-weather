<?php

namespace App\MessageHandler;

use App\Message\CurrentWeatherMessage;
use App\Model\WeatherNow;
use Cmfcmf\OpenWeatherMap;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CurrentWeatherHandler
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

    public function __invoke(CurrentWeatherMessage $sendWeatherMessage): WeatherNow
    {
        $weatherData = $this->openWeatherMap->getWeather(
            $sendWeatherMessage->getLocation(),
            $sendWeatherMessage->getUnits()
        );
        return new WeatherNow($weatherData);
    }
}
