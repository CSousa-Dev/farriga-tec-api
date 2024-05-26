<?php

namespace App\Controller\Device;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SseController extends AbstractController
{
    #[Route('/test', name: 'device_monitoring', methods: ['GET'])]
    public function index(
        LoggerInterface $logger
    ): StreamedResponse
    {
        $response = new StreamedResponse();

        $logger->info('SSE connection opened');

        // Set headers for SSE
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');


        // Example data stream
        $response->setCallback(function () {
            while(true){
                echo "data: " . json_encode(['time' => time()]) . "\n\n";
                ob_flush();
                flush();
                sleep(1);
            
            }
        });

        return $response;
    }
}
