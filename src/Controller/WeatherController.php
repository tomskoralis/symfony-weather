<?php

namespace App\Controller;

use App\Message\WeatherMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(): Response
    {
        return $this->render('weather/index.html.twig');
    }

    #[Route('/api/weather', name: 'app_weather_data')]
    public function weather(Request $request, MessageBusInterface $messageBus): JsonResponse
    {
        $location = $request->get('location');
        $units = $request->get('units');
        $weather = $messageBus->dispatch(new WeatherMessage($location, $units))
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse([
            'weather' => $weather,
        ]);
    }
}
