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
    )
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');
        set_time_limit(5000000);

        $logger->info('SSE connection opened');

        echo "data: " . json_encode(['time' => time()]) . "\n\n";
        ob_flush();
        flush();

        while(true){
            if(connection_aborted()){
                $logger->info('SSE connection closed');
                break;
            }

            echo "data: " . json_encode(['time' => time()]) . "\n\n";
            ob_flush();
            flush();
            sleep(1);
        }
    
    }
}
