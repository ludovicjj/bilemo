<?php

namespace App\Action\Phone;

use App\Domain\Phone\AddPhone\persister;
use App\Domain\Phone\AddPhone\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddPhone
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var persister  */
    protected $persister;

    /**
     * AddPhone constructor.
     * @param RequestResolver $requestResolver
     * @param persister $persister
     */
    public function __construct(
        RequestResolver $requestResolver,
        persister $persister
    )
    {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/makers/{maker_id}/phones", name="add_phone", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \App\Domain\Commun\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $input = $this->requestResolver->resolve($request);
        $output = $this->persister->persist($input);

        return JsonResponder::response(
            null,
            Response::HTTP_CREATED,
            $output
        );
    }
}