<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Commun\Exceptions\ProcessorErrorsHttp;
use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var DeleteUserInput  */
    protected $deleteUserInput;

    /** @var Security  */
    protected $security;

    /**
     * RequestResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param DeleteUserInput $deleteUserInput
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DeleteUserInput $deleteUserInput,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->deleteUserInput = $deleteUserInput;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return DeleteUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): DeleteUserInput
    {
        $clientId = $request->attributes->get('client_id');
        $userId = $request->attributes->get('user_id');

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Vous n\'êtes pas autorisé à supprimer un utilisateur dans ce catalogue.'
            );
        }

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        if (!$user) {
            ProcessorErrorsHttp::throwNotFound(sprintf('Aucun utilisateur ne correspond à l\'id : %s', $userId));
        }

        $this->deleteUserInput->setUser($user);

        return $this->deleteUserInput->getInput();
    }
}
