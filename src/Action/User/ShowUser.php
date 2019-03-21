<?php

namespace App\Action\User;

use App\Domain\User\ShowUser\NormalizerData;
use App\Domain\User\ShowUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Domain\Entity\User;

class ShowUser
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var NormalizerData  */
    protected $normalizerData;

    /**
     * ShowUser constructor.
     * @param RequestResolver $requestResolver
     * @param NormalizerData $normalizerData
     */
    public function __construct(
        RequestResolver $requestResolver,
        NormalizerData $normalizerData
    ) {
        $this->requestResolver = $requestResolver;
        $this->normalizerData = $normalizerData;
    }

    /**
     * @Route("/api/clients/{client_id}/users/{user_id}", name="show_user", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(Request $request): Response
    {
        $input = $this->requestResolver->resolve($request);
        $data = $this->normalizerData->normalize($input);

        return JsonResponder::response(
            $data,
            Response::HTTP_OK,
            true
        );
    }
}
