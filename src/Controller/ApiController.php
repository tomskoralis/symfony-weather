<?php

namespace App\Controller;

use App\Message\WeatherMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/weather", name="api_weather")
     */
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
