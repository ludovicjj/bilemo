<?php

namespace App\Domain\Commun;

use App\Domain\Commun\Exceptions\ValidatorException;
use App\Responders\JsonResponder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onProcessException'
        ];
    }

    public function onProcessException(GetResponseForExceptionEvent $event)
    {
        switch (get_class($event->getException())) {
            case ValidatorException::class:
                $this->processValidatorException($event);
                break;
        }
    }

    public function processValidatorException(GetResponseForExceptionEvent $event)
    {
        /** @var ValidatorException $exception */
        $exception = $event->getException();
        $event
            ->setResponse(
                JsonResponder::response(
                    json_encode($exception->getErrors()),
                    $exception->getStatusCode()
                )
            );
    }
}