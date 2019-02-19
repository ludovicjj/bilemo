<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var DeleteUserInput  */
    protected $deleteUserInput;

    /**
     * RequestResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param DeleteUserInput $deleteUserInput
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DeleteUserInput $deleteUserInput
    )
    {
       $this->entityManager = $entityManager;
       $this->deleteUserInput = $deleteUserInput;
    }

    /**
     * @param Request $request
     * @return DeleteUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): DeleteUserInput
    {
        //TODO Recuperation de id de user dans url
        $userId = $request->attributes->get('id');

        //TODO Recupere user correspondant a id
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        //TODO Si aucun user ne correspond a id
        if (!$user) {
            throw new NotFoundHttpException(sprintf('aucun utilisateur ne correspond à l\'id : "%s"', $userId));
        }

        //TODO Hydrate DeleteUserInput
        $input = $this->deleteUserInput->setUser($user);

        return $input;
    }
}