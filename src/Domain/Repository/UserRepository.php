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
        return $this->createQueryBuilder('u')
            ->leftJoin('u.client', 'c')
            ->andWhere('c.id = :client_id')
            ->setParameter('client_id',  $clientId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param string $userId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function userExist(string $userId)
    {
        return $this->createQueryBuilder('user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function checkUserNotExistByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getScalarResult();
    }
}