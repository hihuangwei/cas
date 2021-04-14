<?php

namespace Hihuangwei\CAS\Responses;

use Hihuangwei\CAS\Contracts\Responses\AuthenticationSuccessResponse;

class JsonAuthenticationSuccessResponse extends BaseJsonResponse implements AuthenticationSuccessResponse
{
    /**
     * JsonAuthenticationSuccessResponse constructor.
     */
    public function __construct()
    {
        $this->data = ['serviceResponse' => ['authenticationSuccess' => []]];
    }

    public function setUser($user)
    {
        $this->data['serviceResponse']['authenticationSuccess']['user'] = $user;

        return $this;
    }

    public function setProxies($proxies)
    {
        $this->data['serviceResponse']['authenticationSuccess']['proxies'] = $proxies;

        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->data['serviceResponse']['authenticationSuccess']['attributes'] = $attributes;

        return $this;
    }

    public function setProxyGrantingTicket($ticket)
    {
        $this->data['serviceResponse']['authenticationSuccess']['proxyGrantingTicket'] = $ticket;

        return $this;
    }
}
