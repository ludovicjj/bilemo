<?php

namespace App\Application\Subscribers;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = 'Mauvais identifiants';

        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }
}