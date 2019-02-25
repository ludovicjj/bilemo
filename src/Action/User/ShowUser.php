<?php

namespace App\Action\User;


use App\Domain\User\ShowUser\Loader;
use App\Domain\User\ShowUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowUser
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Loader  */
    protected $loader;

    /**
     * ShowUser constructor.
     * @param RequestResolver $requestResolver
     * @param Loader $loader
     */
    public function __construct(
        RequestResolver $requestResolver,
        Loader $loader
    )
    {
        $this->requestResolver = $requestResolver;
        $this->loader = $loader;
    }

    /**
     * @Route("/api/clients/{client_id}/users/{user_id}", name="show_user", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(Request $request)
    {
        $input = $this->requestResolver->resolve($request);
        $datas = $this->loader->load($input);

        Return JsonResponder::response(
            $datas,
            Response::HTTP_OK
        );
    }
}