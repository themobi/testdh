<?php

namespace App\Application\Handler\User;

use App\Application\Handler\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Service\User\SignupRequest;
use App\Application\Service\User\SignupService;

final class SignUpUserHandler
{
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function __invoke(Request $request, SignupService $service)
    {
        $result = $service->execute(
            new SignupRequest(
                $request->request->get("name"),
                $request->request->get("email"),
                $request->request->get("password")
            )
        );

        return Responder::response(StatusCodeInterface::STATUS_OK, $result);
    }
}
