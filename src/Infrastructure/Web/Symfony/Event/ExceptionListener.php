<?php

namespace App\Infrastructure\Web\Symfony\Event;

use Fig\Http\Message\StatusCodeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{

    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function onKernelException(ExceptionEvent $event)
    {
        // throw exception code
        $event->allowCustomResponseCode();
        
        // You get the exception object from the received event
        $exception = $event->getException();

        // Customize your response object to display the exception details
        $response = new Response();
        
        $code = $exception->getCode();

        $message = $exception->getMessage();

        //! TODO: Needs to implement error/exception logging here

        if ($exception->getCode() === 0) {
            $code = 500;
            //$message = "Something went wrong. please try again later.";
        }


        $response->setStatusCode($code);
        
        $response->setContent(
            json_encode([
                "header" => [
                    "code" => $code,
                    "message" => $message
                ],
                "body" => []
            ], JSON_FORCE_OBJECT)
        );

        $response->headers->set('Content-Type', 'application/json');

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
