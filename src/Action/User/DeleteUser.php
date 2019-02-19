<?php

namespace App\Action\User;

use App\Domain\User\DeleteUser\DeleteUserInput;
use App\Domain\User\DeleteUser\Persister;
use App\Domain\User\DeleteUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUser
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Persister  */
    protected $persister;

    /**
     * DeleteUser constructor.
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
     * @Route("/api/users/{id}", name="delete_user", methods={"DELETE"})
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function delete(Request $request)
    {
        /** @var DeleteUserInput $input */
        $input = $this->requestResolver->resolve($request);
        $this->persister->save($input);

        return JsonResponder::response(
            null,
            Response::HTTP_NO_CONTENT,
            []
        );
    }
}