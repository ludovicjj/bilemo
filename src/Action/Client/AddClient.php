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
     * @Route("/api/registration/client", name="add_client", methods={"POST"})
     * @param Request $request
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     * @throws \Exception
     * @return Response
     */
    public function add(Request $request)
    {
        /** @var AddClientInput $input */
        $input = $this->requestResolver->resolve($request);

        $output = $this->persister->persist($input);

        return JsonResponder::response(
            null,
            Response::HTTP_CREATED,
            $output
        );

    }
}