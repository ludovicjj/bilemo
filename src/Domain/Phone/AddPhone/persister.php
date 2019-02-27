<?php

namespace App\Domain\Phone\AddPhone;


use App\Domain\Commun\Factory\PhoneFactory;
use Doctrine\ORM\EntityManagerInterface;

class persister
{
    protected $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AddPhoneInput $input
     * @return array
     * @throws \Exception
     */
    public function persist(AddPhoneInput $input)
    {
        $phone = PhoneFactory::create(
            $input->getName(),
            $input->getDescription(),
            $input->getPrice(),
            $input->getStock(),
            $input->getMaker()
        );

        $this->entityManager->persist($phone);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/makers/%s/phones/%s',$phone->getMaker()->getId(), $phone->getId())
        ];
    }
}