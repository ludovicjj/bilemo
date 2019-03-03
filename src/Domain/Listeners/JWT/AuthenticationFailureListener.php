<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = 'Bad credentials, please verify that your username/password are correctly set';

        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }
}