<?php

namespace Hihuangwei\CAS\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Hihuangwei\CAS\Contracts\Models\UserModel;

class CasUserLoginEvent extends Event
{
    use SerializesModels;

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var UserModel
     */
    protected $user;

    /**
     * CasUserLoginEvent constructor.
     * @param Request $request
     * @param UserModel $user
     */
    public function __construct(Request $request, UserModel $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return UserModel
     */
    public function getUser()
    {
        return $this->user;
    }
}
