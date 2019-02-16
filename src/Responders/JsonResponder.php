<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    /**
     * @param string|null $datas
     * @param int $statusCode
     * @param array $additionalHeaders
     * @return Response
     */
    public static function response(
        ?string $datas,
        int $statusCode = Response::HTTP_OK,
        array $additionalHeaders = []
    )
    {
        return new Response(
            $datas,
            $statusCode,
            array_merge(
                [
                    'content-type' => 'application/json'
                ],
                $additionalHeaders
            )
        );
    }
}