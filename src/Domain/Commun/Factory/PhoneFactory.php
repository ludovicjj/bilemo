<?php

namespace App\Domain\Commun\Factory;

use App\Domain\Entity\Maker;
use App\Domain\Entity\Phone;

class PhoneFactory
{
    /**
     * @param string $name
     * @param string $description
     * @param string $price
     * @param string $stock
     * @param Maker $maker
     * @return Phone
     * @throws \Exception
     */
    public static function create(
        string $name,
        string $description,
        string $price,
        string $stock,
        Maker $maker
    )
    {
        $phone = new Phone();
        $phone->createPhone(
            $name,
            $description,
            $price,
            $stock,
            $maker
        );

        return $phone;
    }
}