<?php

namespace Hihuangwei\CAS\Responses;

use Hihuangwei\CAS\Contracts\Responses\ProxyFailureResponse;

class XmlProxyFailureResponse extends BaseXmlResponse implements ProxyFailureResponse
{
    /**
     * @param string $code
     * @param string $description
     * @return $this
     */
    public function setFailure($code, $description)
    {
        $this->removeByXPath($this->node, 'cas:proxyFailure');
        $authNode = $this->node->addChild('cas:proxyFailure', $description);
        $authNode->addAttribute('code', $code);

        return $this;
    }
}
