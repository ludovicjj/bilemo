<?php

namespace App\Domain\Phone\ListPhone;

use App\Domain\Commun\Pagination\PaginationFactory;
use App\Domain\Commun\Pagination\Paginator;
use App\Domain\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class Loader
{
    /** @var ListPhoneInput  */
    protected $listPhoneInput;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var PaginationFactory */
    protected $paginationFactory;

    /**
     * Loader constructor.
     * @param ListPhoneInput $listPhoneInput
     * @param EntityManagerInterface $entityManager
     * @param PaginationFactory $paginationFactory
     */
    public function __construct(
        ListPhoneInput $listPhoneInput,
        EntityManagerInterface $entityManager,
        PaginationFactory $paginationFactory
    ) {
        $this->listPhoneInput = $listPhoneInput;
        $this->entityManager = $entityManager;
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * @param Request $request
     * @return ListPhoneInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function load(Request $request)
    {
        /** @var Paginator $currentPhone */
        $currentPhone =$this->paginationFactory->createCollection(
            $this->entityManager->getRepository(Phone::class),
            $request
        );

        $this->listPhoneInput->setPhone($currentPhone->getItemsForCurrentPage());

        return $this->listPhoneInput->getInput();
    }
}
