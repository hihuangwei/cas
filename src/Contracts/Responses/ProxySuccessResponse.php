<?php

namespace Hihuangwei\CAS\Contracts\Responses;

interface ProxySuccessResponse extends BaseResponse
{
    /**
     * @param string $ticket
     * @return $this
     */
    public function setProxyTicket($ticket);
}
