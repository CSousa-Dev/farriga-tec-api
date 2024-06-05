<?php 

namespace App\EventListener;

use App\Application\InvalidInputException;
use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
class DomainExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        if(!$event->getThrowable() instanceof DomainException)
        {
            return;
        }
    
        /**
         * @var InvalidInputException
         */
        $exception = $event->getThrowable();

        $data = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];
            
        $response = new JsonResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        $event->setResponse($response);

    }
}