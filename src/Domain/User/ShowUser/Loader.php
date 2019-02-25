<?php

namespace App\Domain\User\ShowUser;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class Loader
{
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function load(ShowUserInput $input): string
    {
        //Todo Serialize User
        $datas = $this->serializer->serialize(
            $input->getUser(),
            'json',
            SerializationContext::create()->setGroups(['details_user'])
        );

        return $datas;
    }
}