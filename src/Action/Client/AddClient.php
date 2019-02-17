<?php

namespace App\Action\Client;

use App\Domain\Client\AddClient\AddClientInput;
use App\Domain\Client\AddClient\Persister;
use App\Domain\Client\AddClient\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddClient
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Persister  */
    protected $persister;

    /**
     * AddClient constructor.
     *
     * @param RequestResolver $requestResolver
     * @param Persister $persister
     */
    public function __construct(
        RequestResolver $requestResolver,
        Persister $persister
    )
    {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/clients", name="add_client", methods={"POST"})
     * @param Request $request
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     * @throws \Exception
     * @return Response
     */
    public function add(Request $request)
    {
        //TODO 1. Hydratation de la classe AddClientInput avec les données dans la requete via le composant serializer et la methode deserialize
        //TODO 2. Validation de la classe AddClientInput
        //TODO 3. Return AddClientInput
        /** @var AddClientInput $input */
        $input = $this->requestResolver->resolve($request);

        //TODO 1. Création de l'objet Client + hydration + persistance
        //TODO 2. Retourn array avec location
        $output = $this->persister->persist($input);

        //TODO 1. Retourne Response
        //TODO 2. StatusCode = 201 (HTTP_CREATED)
        //TODO 2. array_merge [content-type => application/json] + [location => $output]
        return JsonResponder::response(
            null,
            Response::HTTP_CREATED,
            $output
        );

    }
}