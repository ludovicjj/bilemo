<?php

namespace App\Action\Phone;

use App\Domain\Phone\ListPhone\Loader;
use App\Domain\Phone\ListPhone\NormalizerData;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Domain\Entity\Phone;

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
     *     @SWG\Schema(
     *     type="array",
     *         @SWG\Items(ref=@Model(type=Phone::class, groups={"list_phone"}))
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Your token is expired, please renew it",
     *     @SWG\Schema(ref="#/definitions/JwtErrorOutput")
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Missing or invalid token.",
     *     @SWG\Schema(ref="#/definitions/JwtErrorOutput")
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