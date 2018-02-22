<?php
namespace Aksara\AdminNotif;

interface AdminNotifHandler
{
    public function handle(AdminNotifRequest $request);
}
