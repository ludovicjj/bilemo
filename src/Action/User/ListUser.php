<?php

namespace App\Action\User;

use App\Domain\User\ListUser\Loader;
use App\Domain\User\ListUser\NormalizerData;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

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
     *
     * @SWG\Parameter(
     *     name="client_id",
     *     in="path",
     *     type="string",
     *     description="The client unique identifier.",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get the list of all users.",
     *     @SWG\Schema(ref="#/definitions/ListUserOutput"),
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
     * @Security(name="Bearer")
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