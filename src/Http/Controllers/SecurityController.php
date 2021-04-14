<?php

namespace Hihuangwei\CAS\Http\Controllers;

use Hihuangwei\CAS\Contracts\Interactions\UserLogin;
use Hihuangwei\CAS\Contracts\Models\UserModel;
use Hihuangwei\CAS\Events\CasUserLoginEvent;
use Hihuangwei\CAS\Events\CasUserLogoutEvent;
use Hihuangwei\CAS\Exceptions\CAS\CasException;
use Illuminate\Http\Request;
use Hihuangwei\CAS\Repositories\PGTicketRepository;
use Hihuangwei\CAS\Repositories\ServiceRepository;
use Hihuangwei\CAS\Repositories\TicketRepository;

class SecurityController extends Controller
{
    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;

    /**
     * @var TicketRepository
     */
    protected $ticketRepository;

    /**
     * @var PGTicketRepository
     */
    protected $pgTicketRepository;
    /**
     * @var UserLogin
     */
    protected $loginInteraction;

    /**
     * SecurityController constructor.
     * @param ServiceRepository $serviceRepository
     * @param TicketRepository $ticketRepository
     * @param PGTicketRepository $pgTicketRepository
     * @param UserLogin $loginInteraction
     */
    public function __construct(
        ServiceRepository $serviceRepository,
        TicketRepository $ticketRepository,
        PGTicketRepository $pgTicketRepository,
        UserLogin $loginInteraction
    )
    {
        $this->serviceRepository = $serviceRepository;
        $this->ticketRepository = $ticketRepository;
        $this->loginInteraction = $loginInteraction;
        $this->pgTicketRepository = $pgTicketRepository;
    }

    public function showLogin(Request $request)
    {
        $service = $request->get('service', '');
        $errors = [];
        if (!empty($service)) {
            //service not found in white list
            if (!$this->serviceRepository->isUrlValid($service)) {
                $errors[] = (new CasException(CasException::INVALID_SERVICE))->getCasMsg();
            }
        }

        $user = $this->loginInteraction->getCurrentUser($request);
        //user already has sso session
        if ($user) {
            //has errors, should not be redirected to target url
            if (!empty($errors)) {
                return redirect('portal');
            }

            //must not be transparent
            if ($request->get('warn') === 'true' && !empty($service)) {
                $query = $request->query->all();
                unset($query['warn']);
                $url = $this->cas_route('login_page', $query);

                return $this->loginInteraction->showLoginWarnPage($request, $url, $service);
            }

            return $this->authenticated($request, $user);

        }

        return $this->loginInteraction->showLoginPage($request, $errors);
    }

    public function login(Request $request)
    {
        $user = $this->loginInteraction->login($request);
        if (is_null($user)) {
            return $this->loginInteraction->showAuthenticateFailed($request);
        }

        return $this->authenticated($request, $user);
    }

    public function authenticated(Request $request, UserModel $user)
    {
        event(new CasUserLoginEvent($request, $user));
        $serviceUrl = $request->get('service', '');
        if (!empty($serviceUrl)) {
            $query = parse_url($serviceUrl, PHP_URL_QUERY);
            try {
                $ticket = $this->ticketRepository->applyTicket($user, $serviceUrl);
            } catch (CasException $e) {
                return redirect('portal');
            }
            $finalUrl = $serviceUrl . ($query ? '&' : '?') . 'ticket=' . $ticket->ticket;

            return redirect($finalUrl);
        }

        return redirect('portal');
    }

    public function logout(Request $request)
    {
        $user = $this->loginInteraction->getCurrentUser($request);
        if ($user) {
            $this->loginInteraction->logout($request);
            $this->pgTicketRepository->invalidTicketByUser($user);
            event(new CasUserLogoutEvent($request, $user));
        }
        $service = $request->get('service');
        if ($service && $this->serviceRepository->isUrlValid($service)) {
            return redirect($service);
        }

        return redirect('/');
    }

    public function cas_route($name, $parameters = [], $absolute = true)
    {
        $name = config('cas.router.name_prefix') . $name;

        return route($name, $parameters, $absolute);
    }
}
