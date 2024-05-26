<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SseController extends AbstractController
{
    #[Route('/test', name: 'device_monitoring', methods: ['GET'])]
    public function index(): StreamedResponse
    {
        $response = new StreamedResponse();

        // Set headers for SSE
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        // Example data stream
        $response->setCallback(function () {
            while (true) {
                echo "data: " . json_encode(['time' => date('now')]) . "\n\n";
                ob_flush();
                flush();
                sleep(1);
            }
        });

        return $response;
    }
}
