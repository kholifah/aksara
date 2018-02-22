<?php
namespace Aksara\AdminNotif;

use Aksara\Repository\SessionRepository;

class Interactor implements AdminNotifHandler
{
    const SESSION_VAR_NAME = 'admin_notice';

    private $sessionRepo;

    public function __construct(
        SessionRepository $sessionRepo
    ){
        $this->sessionRepo = $sessionRepo;
    }

    public function handle(AdminNotifRequest $request)
    {
        $notice = $request->toArray();
        if ($this->sessionRepo->has(self::SESSION_VAR_NAME)) {
            $messages = $this->sessionRepo->get(self::SESSION_VAR_NAME);
            array_push($messages, $notice);
            $this->sessionRepo->flash(self::SESSION_VAR_NAME, $messages);
        } else {
            $this->sessionRepo->flash(self::SESSION_VAR_NAME, [ $notice ]);
        }
    }
}

