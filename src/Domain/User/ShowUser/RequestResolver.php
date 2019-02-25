<?php

namespace App\Domain\User\ShowUser;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;
    /** @var ShowUserInput  */
    protected $showUserInput;

    /**
     * RequestResolver constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ShowUserInput $showUserInput
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ShowUserInput $showUserInput
    )
    {
        $this->entityManager = $entityManager;
        $this->showUserInput = $showUserInput;
    }

    /**
     * @param Request $request
     * @return ShowUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request)
    {
        //TODO Get $_GET['user_id']
        $userId = $request->attributes->get('user_id');

        //TODO Get user by UserRepository with findOneOrNullResult
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        //TODO Check User (Exception if user is null)
        if (!$user) {
            throw new NotFoundHttpException(sprintf('Aucun utilisateur ne correspond à l\'id : "%s"', $userId));
        }

        //TODO Hydrate ShowUserInput
        $this->showUserInput->setUser($user);

        //TODO Return ShowUserInput
        return $this->showUserInput->getInput();
    }
}