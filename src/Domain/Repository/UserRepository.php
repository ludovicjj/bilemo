<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserByClientId(string $clientId): ? array
    {
        return $this->createQueryBuilder('user')
            ->leftJoin('user.client', 'client')
            ->andWhere('client.id = :client_id')
            ->setParameter('client_id',  $clientId)
            ->getQuery()
            ->getResult();
    }
}