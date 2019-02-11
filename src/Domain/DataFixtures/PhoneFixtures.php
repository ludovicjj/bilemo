<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Maker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Domain\Entity\Phone;


class PhoneFixtures extends fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $phone = new Phone();
        $maker = new Maker('fabricant1');
        $phone->createPhone(
            'name',
            'description',
            '99',
            $maker
        );
        $manager->persist($phone);
        $manager->flush();
    }
}