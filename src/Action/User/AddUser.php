<?php

namespace App\Action\User;

use App\Domain\User\AddUser\Persister;
use App\Domain\User\AddUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

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
    )
    {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/clients/{client_id}/users", name="add_user", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="client_id",
     *     in="path",
     *     type="string",
     *     description="The client unique identifier.",
     *     required=true
     * )
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     @SWG\Schema(ref="#/definitions/AddUserInput"),
     *     description="Request payload contain all informations",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Successful submit."
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="Your token is expired, please renew it"
     * )
     *
     * @SWG\Response(
     *     response=403,
     *     description="you must login to access this resource."
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Bad request. Check your request."
     * )
     *
     * @Security(name="Bearer")
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