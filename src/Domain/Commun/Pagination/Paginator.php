<?php

namespace App\Domain\Commun\Pagination;

use App\Domain\Repository\PhoneRepository;

class Paginator
{
    /** @var PhoneRepository  */
    private $repository;

    /** @var int */
    private $itemsPerPage;

    /** @var int */
    private $currentPage;

    /** @var int */
    private $nbItems;

    /** @var mixed */
    private $currentItems;

    /**
     * Paginator constructor.
     * @param PhoneRepository $repository
     * @param int $currentPage
     * @param int $itemsPerPage
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __construct(
        PhoneRepository $repository,
        int $currentPage,
        int $itemsPerPage
    ) {
        $this->repository = $repository;

        //Define current page with default value is 1
        $this->currentPage = $currentPage;

        //Define setMaxResult with param in services.yaml
        $this->itemsPerPage = $itemsPerPage;

        //Define number of items
        $this->nbItems = $repository->countAll();

        //Define setFirstResult
        $first = $currentPage * $this->itemsPerPage - $this->itemsPerPage;

        //Get current items for current page
        $this->currentItems = $this->repository->getPhoneByPage($first, $this->itemsPerPage);
    }

    /**
     * Get items for current page
     * @return mixed
     */
    public function getItemsForCurrentPage()
    {
        return $this->currentItems;
    }

    /**
     * Get number of items
     * @return int
     */
    public function getNbItems(): int
    {
        return $this->nbItems;
    }

    /**
     * Get number of pages
     * @return int
     */
    public function getNbPages()
    {
        return (int) ceil($this->nbItems/$this->itemsPerPage);
    }
}
