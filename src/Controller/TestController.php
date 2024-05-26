<?php

namespace App\Controller;

use App\Application\Device\Services\ListenAllUserDeviceEventsService;
use App\Domain\Devices\Repository\IDeviceRepository;
use Psr\Log\LoggerInterface;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(
        ListenAllUserDeviceEventsService $listenAllUserDeviceEventsService,
    )
    {
        $listenAllUserDeviceEventsService->execute(2);
        dd($listenAllUserDeviceEventsService->getConfiguredEventManager());
    }
}
