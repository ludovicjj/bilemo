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

    /**
     * AddUser constructor.
     * @param RequestResolver $requestResolver
     * @param Persister $persister
     */
    public function __construct(
        RequestResolver $requestResolver,
        Persister $persister
    ) {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/clients/{client_id}/users", name="add_user", methods={"POST"})
     *
     *
     * @param Request $request
     * @return Response
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
