<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Maker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MakerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Maker::class);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findMakerByName(string $name)
    {
        return $this->createQueryBuilder('m')
            ->where('m.name = :maker_name')
            ->setParameter('maker_name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}