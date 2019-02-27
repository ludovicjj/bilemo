<?php

namespace App\Domain\Commun\Factory;


use App\Domain\Entity\Maker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MakerFactory
{
    /** @var UserPasswordEncoderInterface  */
    protected $passwordEncoder;

    /**
     * MakerFactory constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Maker
     * @throws \Exception
     */
    public function create(
        string $username,
        string $password
    )
    {
        $maker = new Maker();
        $maker->createMaker(
            $username,
            $this->passwordEncoder->encodePassword($maker, $password)
        );

        return $maker;
    }
}