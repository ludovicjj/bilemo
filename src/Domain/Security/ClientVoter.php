<?php

namespace App\Domain\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ClientVoter extends Voter
{
    protected function supports($attribute, $object)
    {
        /**
         * L'un des votants par défaut gère tout ce qui commence par ROLE_
         * Créer un nouveau votant qui décide de l'accès chaque fois que nous passons CLIENT_ADD à isGranted().
         */
        if ($attribute != 'CLIENT_ADD') {

            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $object, TokenInterface $token)
    {
        $currentClientId = $token->getUser()->getId()->toString();

        if ($object !== $currentClientId) {

            throw new AccessDeniedException('Vous n\'êtes pas autorisé à ajouter cet utilisateur.');
        }
    }
}