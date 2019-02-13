<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends fixture
{
    protected $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->createClient(
            'ludovicjj',
            $this->passwordEncoder->encodePassword($client, 'test'),
            'jahanlud@gmail.com'
        );
        $manager->persist($client);
        $manager->flush();
    }
}