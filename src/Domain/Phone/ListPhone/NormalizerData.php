<?php

namespace App\Domain\Phone\ListPhone;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class NormalizerData
{
    /** @var SerializerInterface  */
    protected $serializer;

    /**
     * NormalizerData constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function normalize(ListPhoneInput $input)
    {
        $data = $this->serializer->serialize(
            $input->getPhone(),
            'json',
            SerializationContext::create()->setGroups(['list_phone'])
        );

        return $data;
    }
}