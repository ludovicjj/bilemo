<?php

namespace App\Domain\Phone\ShowPhone;

use App\Domain\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestResolver
{
    /** @var ShowPhoneInput  */
    protected $showPhoneInput;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    public function __construct(
        ShowPhoneInput $input,
        EntityManagerInterface $entityManager
    )
    {
        $this->showPhoneInput = $input;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return ShowPhoneInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): ShowPhoneInput
    {
        $phoneId = $request->attributes->get('phone_id');
        $phone = $this->entityManager->getRepository(Phone::class)->phoneExist($phoneId);

        if (!$phone) {
            throw new NotFoundHttpException(sprintf('Aucun téléphone ne correspond à l\'id : "%s"', $phoneId));
        }

        $this->showPhoneInput->setPhone($phone);

        return $this->showPhoneInput->getInput();
    }
}