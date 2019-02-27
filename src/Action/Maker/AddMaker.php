<?php

namespace App\Action\Maker;

use App\Domain\Maker\AddMaker\AddMakerInput;
use App\Domain\Maker\AddMaker\Persister;
use App\Domain\Maker\AddMaker\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddMaker
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Persister  */
    protected $persister;

    /**
     * AddMaker constructor.
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
     * @Route("/api/registration/maker", name="add_maker", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     */
    public function add(Request $request)
    {
        /** @var AddMakerInput $input */
        $input = $this->requestResolver->resolve($request);
        $output = $this->persister->persist($input);

        return JsonResponder::response(
            null,
            Response::HTTP_CREATED,
            $output
        );

    }
}