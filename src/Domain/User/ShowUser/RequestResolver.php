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
        $userId = $request->attributes->get('user_id');
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('Aucun utilisateur ne correspond à l\'id : "%s"', $userId));
        }
        $this->showUserInput->setUser($user);

        return $this->showUserInput->getInput();
    }
}