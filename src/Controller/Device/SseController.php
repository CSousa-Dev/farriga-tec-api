<?php

namespace App\Controller\Device;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SseController extends AbstractController
{
    #[Route('/test', name: 'device_monitoring', methods: ['GET'])]
    public function sseAction(): StreamedResponse
    {
        // Set response headers
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Connection', 'keep-alive');

        // Send data periodically
        $response->setCallback(function () {
            while (true) {

                if(connection_aborted()) {
                    exit();
                }

                // Fetch data to send
                $data = (new \DateTime('now'))->format('Y-m-d H:i:s');

                // Send data to client
                echo "data: " . json_encode($data) . "\n\n";
                flush();

                // Send a heartbeat message every 25 seconds
                sleep(5);
                echo ":\n\n"; // Heartbeat message
                flush();
            }
        });

        return $response;
    }
}
