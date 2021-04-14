<?php

namespace Hihuangwei\CAS\Responses;

use Hihuangwei\CAS\Contracts\Responses\ProxySuccessResponse;
use SimpleXMLElement;

class XmlProxySuccessResponse extends BaseXmlResponse implements ProxySuccessResponse
{
    /**
     * XmlProxySuccessResponse constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->node->addChild('cas:proxySuccess');
    }

    /**
     * @param string $ticket
     * @return $this
     */
    public function setProxyTicket($ticket)
    {
        $proxyNode = $this->getProxyNode();
        $this->removeByXPath($proxyNode, 'cas:proxyTicket');
        $proxyNode->addChild('cas:proxyTicket', $ticket);

        return $this;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getProxyNode()
    {
        $authNodes = $this->node->xpath('cas:proxySuccess');
        if (count($authNodes) < 1) {
            return $this->node->addChild('cas:proxySuccess');
        }

        return $authNodes[0];
    }
}
