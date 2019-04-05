<?php

namespace App\Domain\Commun\Pagination;

use App\Domain\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginationFactory
{
    /**
     * @var int
     */
    private $itemsPerPage;

    public function __construct(
        int $itemsPerPage
    ) {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @param PhoneRepository $phoneRepository
     * @param Request $request
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createCollection(
        PhoneRepository $phoneRepository,
        Request $request
    ) {

        //Get param "page" and define default value (int) 1
        $currentPage = (int) $request->query->get('page', 1);

        //Check if page exist
        if ($currentPage > (int) ceil($phoneRepository->countAll()/$this->itemsPerPage) || $currentPage < 1) {
            throw new NotFoundHttpException(
                sprintf('La page %s n\'existe pas', $currentPage)
            );
        }

        $paginator = new Paginator($phoneRepository, $currentPage, $this->itemsPerPage);


        return $paginator;
    }
}
