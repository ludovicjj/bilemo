<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PhoneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Phone::class);
    }

    /**
     * @param string $phoneId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function phoneExist(string $phoneId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :phone_id')
            ->setParameter('phone_id', $phoneId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findPhoneByName(string $name)
    {
        return $this->createQueryBuilder('p')
            ->where('p.name = :phone_name')
            ->setParameter('phone_name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAll(): int
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getPhoneByPage(int $first, int $maxResults)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setFirstResult($first)
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
