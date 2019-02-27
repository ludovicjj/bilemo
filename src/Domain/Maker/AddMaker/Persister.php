<?php

namespace App\Domain\Maker\AddMaker;

use App\Domain\Commun\Factory\ErrorsValidationFactory;
use App\Domain\Commun\Factory\MakerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Persister
{
    /** @var MakerFactory  */
    protected $makerFactory;

    /** @var ValidatorInterface  */
    protected $validator;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * Persister constructor.
     * @param MakerFactory $makerFactory
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        MakerFactory $makerFactory,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {
        $this->makerFactory = $makerFactory;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    /**
     * @param AddMakerInput $input
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     * @throws \Exception
     * @return array
     */
    public function persist(AddMakerInput $input)
    {
        //Creation de l'entité Maker avec les données de l'input
        $maker = $this->makerFactory->create(
            $input->getUsername(),
            $input->getPassword()
        );

        //Validation de l'entité Maker
        $constraintList = $this->validator->validate($maker);

        //Traitement des erreurs
        ErrorsValidationFactory::buildError($constraintList);

        //Enregistrement en BDD
        $this->entityManager->persist($maker);
        $this->entityManager->flush();

        return [
            'location' => sprintf('http://127.0.0.1:8000/api/makers/%s', $maker->getId())
        ];
    }
}