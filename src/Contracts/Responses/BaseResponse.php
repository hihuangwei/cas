<?php

namespace Hihuangwei\CAS\Contracts\Responses;

use Symfony\Component\HttpFoundation\Response;

interface BaseResponse
{
    /**
     * @return Response
     */
    public function toResponse();
}
