<?php

namespace App\Action\User;

use App\Domain\User\AddUser\Persister;
use App\Domain\User\AddUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddUser
{
    /** @var RequestResolver */
    protected $requestResolver;

    /** @var Persister */
    private $persister;

    public function __construct(
        RequestResolver $requestResolver,
        Persister $persister
    )
    {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/users", name="add_user", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function add(Request $request)
    {
        //TODO 1. Recupere l'utilisateur courant
        //TODO 2. Hydratation de la classe AddUserInput avec les données dans la requete via le composant serializer et la methode deserialize
        //TODO 3. Validation de la classe AddUserInput
        //TODO 4. Retourne AddUserInput
        $input = $this->requestResolver->resolve($request);

        //TODO 1. Création de l'objet User + hydration + persistance
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