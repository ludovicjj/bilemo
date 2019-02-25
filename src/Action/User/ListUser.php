<?php

namespace App\Action\User;

use App\Domain\User\ListUser\Loader;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListUser
{
    /** @var Loader  */
    protected $loader;

    /**
     * ListUser constructor.
     *
     * @param Loader $loader
     */
    public function __construct(
        Loader $loader
    )
    {
        $this->loader = $loader;
    }

    /**
     * @Route("/api/clients/{client_id}/users", name="list_users", methods={"GET"})
     */
    public function listUsers()
    {
        $datas = $this->loader->load();

        return JsonResponder::response(
            $datas,
            Response::HTTP_OK
        );
    }
}