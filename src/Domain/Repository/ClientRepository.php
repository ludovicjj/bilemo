<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @param string $username
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findClientByUsername(string $username)
    {
        return $this->createQueryBuilder('c')
            ->where('c.username = :client_username')
            ->setParameter('client_username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}