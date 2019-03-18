<?php

namespace App\Domain\User\ShowUser;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Domain\Commun\Exceptions\ProcessorErrorsHttp;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;
    /** @var ShowUserInput  */
    protected $showUserInput;

    protected $security;

    /**
     * RequestResolver constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ShowUserInput $showUserInput
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ShowUserInput $showUserInput,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->showUserInput = $showUserInput;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return ShowUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request)
    {
        $clientId = $request->attributes->get('client_id');

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Vous n\'êtes pas autorisé à consulter les informations de cet utilisateur.'
            );
        }

        $userId = $request->attributes->get('user_id');
        $user = $this->entityManager->getRepository(User::class)->userExist($userId);

        if (!$user) {
            ProcessorErrorsHttp::throwNotFound(sprintf('Aucun utilisateur ne correspond à l\'id : %s', $userId));
        }
        $this->showUserInput->setUser($user);

        return $this->showUserInput->getInput();
    }
}
