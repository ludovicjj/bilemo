<?php

namespace App\Application\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = "Merci de vous authentifier.";

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}