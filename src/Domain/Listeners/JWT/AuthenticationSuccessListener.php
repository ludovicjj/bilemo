<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $client = $event->getUser();

        if (!$client instanceof UserInterface) {
            return;
        }

        $data['client'] = [
            'username' => $client->getUsername(),
            'email' => $client->getEmail(),
            'roles' => $client->getRoles()
        ];

        $event->setData($data);
    }
}