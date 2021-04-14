<?php

namespace Hihuangwei\CAS\Contracts\Responses;

interface ProxyFailureResponse extends BaseResponse
{
    /**
     * @param string $code
     * @param string $description
     * @return $this
     */
    public function setFailure($code, $description);
}
