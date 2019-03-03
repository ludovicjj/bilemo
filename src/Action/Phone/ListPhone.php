<?php

namespace App\Action\Phone;

use App\Domain\Phone\ListPhone\Loader;
use App\Domain\Phone\ListPhone\NormalizerData;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class ListPhone
{
    /** @var Loader  */
    protected $loader;

    /** @var NormalizerData  */
    protected $normalizerData;

    /**
     * ListPhone constructor.
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
     * @Route("/api/phones", name="list_phone", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Get the list of all phones.",
     *     @SWG\Schema(ref="#/definitions/ListPhoneOutput")
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Your token is expired, please renew it"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="you must login to access this resource."
     * )
     * @Security(name="Bearer")
     */
    public function listPhone()
    {
        $input = $this->loader->load();

        $data = $this->normalizerData->normalize($input);

        return JsonResponder::response(
            $data,
            Response::HTTP_OK
        );
    }
}