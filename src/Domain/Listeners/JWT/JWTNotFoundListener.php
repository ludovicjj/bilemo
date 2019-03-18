<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'code'  => 403,
            'message' => 'Missing token.',
        ];

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}
