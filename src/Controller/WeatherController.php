<?php

namespace App\Controller;

use App\Message\CurrentWeatherMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(MessageBusInterface $messageBus): Response
    {
        $weatherRiga = $messageBus->dispatch(new CurrentWeatherMessage('Riga'))
            ->last(HandledStamp::class)
            ->getResult();

        $weatherNewYork = $messageBus->dispatch(new CurrentWeatherMessage('New York', 'imperial'))
            ->last(HandledStamp::class)
            ->getResult();

        return $this->render('weather/index.html.twig', [
            'weatherRiga' => $weatherRiga,
            'weatherNewYork' => $weatherNewYork,
        ]);
    }
}
