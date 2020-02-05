<?php

namespace App\Application\Handler;

/*use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Lcobucci\ContentNegotiation\UnformattedResponse;*/
use Symfony\Component\HttpFoundation\Response;

class Responder
{
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function response($code, $body)
    {
        $response = new Response();

        $response->setStatusCode($code);
        
        $response->setContent(
            json_encode([
                "header" => [
                    "code" => 1,
                    "message" => "success"
                ],
                "body" => $body
            ])
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
