<?php

namespace App\Action\User;

use App\Domain\User\ListUser\Loader;
use App\Domain\User\ListUser\NormalizerData;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListUser
{
    /** @var Loader  */
    protected $loader;

    /** @var NormalizerData  */
    protected $normalizerData;

    /**
     * ListUser constructor.
     * @param Loader $loader
     * @param NormalizerData $normalizerData
     */
    public function __construct(
        Loader $loader,
        NormalizerData $normalizerData
    )
    {
        $this->loader = $loader;
        $this->normalizerData = $normalizerData;
    }

    /**
     * @Route("/api/clients/{client_id}/users", name="list_users", methods={"GET"})
     */
    public function listUsers(): Response
    {
        $input = $this->loader->load();
        $data = $this->normalizerData->normalize($input);


        return JsonResponder::response(
            $data,
            Response::HTTP_OK
        );

    }
}