<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = "You must login to access this resource.";

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}