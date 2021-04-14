<?php

namespace Hihuangwei\CAS\Contracts;

interface TicketLocker
{
    /**
     * @param string $key
     * @param int $timeout
     * @return bool
     */
    public function acquireLock($key, $timeout);

    /**
     * @param string $key
     * @return bool
     */
    public function releaseLock($key);
}
