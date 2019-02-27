<?php

namespace App\Domain\Phone\ListPhone;

use Doctrine\ORM\PersistentCollection;

class ListPhoneInput
{

    protected $phone;

    public function setPhone(PersistentCollection $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): PersistentCollection
    {
        return $this->phone;
    }

    public function getInput(): ListPhoneInput
    {
        return $this;
    }
}