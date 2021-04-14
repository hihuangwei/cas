<?php

namespace Hihuangwei\CAS\Contracts\Responses;

interface AuthenticationSuccessResponse extends BaseResponse
{
    /**
     * @param string $user
     * @return $this
     */
    public function setUser($user);

    /**
     * @param array $proxies
     * @return $this
     */
    public function setProxies($proxies);

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes($attributes);

    /**
     * @param array $ticket
     * @return $this
     */
    public function setProxyGrantingTicket($ticket);
}
