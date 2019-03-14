<?php

namespace App\Domain\Commun\Factory;

use App\Domain\Entity\Maker;

class MakerFactory
{
    /**
     * @param string $name
     * @return Maker
     * @throws \Exception
     */
    public static function create(
        string $name
    )
    {
        $maker = new Maker();
        $maker->createMaker($name);

        return $maker;
    }
}