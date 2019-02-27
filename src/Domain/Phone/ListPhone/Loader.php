<?php

namespace App\Domain\Phone\ListPhone;

use App\Domain\Entity\Maker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Loader
{
    /** @var TokenStorageInterface  */
    protected $tokenStorage;

    /** @var ListPhoneInput  */
    protected $listPhoneInput;

    /**
     * Loader constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ListPhoneInput $listPhoneInput
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ListPhoneInput $listPhoneInput
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->listPhoneInput = $listPhoneInput;
    }

    public function load()
    {
        /** @var Maker $maker */
        $maker = $this->tokenStorage->getToken()->getUser();
        $phone = $maker->getPhones();
        $this->listPhoneInput->setPhone($phone);

        return $this->listPhoneInput->getInput();
    }
}