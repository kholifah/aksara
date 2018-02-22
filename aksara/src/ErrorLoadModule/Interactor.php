<?php
namespace Aksara\ErrorLoadModule;

use Aksara\Exceptions\LoadModuleException;
use Aksara\Repository\SessionRepository;
use Aksara\UpdateModuleStatus\UpdateModuleStatusHandler;

class Interactor implements ErrorLoadModuleHandler
{
    private $sessionRepo;
    private $updateStatusHandler;

    public function __construct(
        SessionRepository $sessionRepo,
        UpdateModuleStatusHandler $updateStatusHandler
    ){
        $this->sessionRepo = $sessionRepo;
        $this->updateStatusHandler = $updateStatusHandler;
    }

    public function handle(LoadModuleException $exception) : ErrorLoadModuleResponse
    {
        $info = '';

        if (!$this->sessionRepo->has('activating_module') &&
            !$this->sessionRepo->has('deactivating_module')
        ){
            //error not occured when changing module status, simply deactivate
            //module that causes problem
            $this->updateStatusHandler->deactivate($exception->getKey());
            $info .= 'Module ' . $exception->getKey()->getModuleName() . ' deactivated.';
        }

        if ($this->sessionRepo->has('activating_module')) {
            $activated = $this->sessionRepo->get('activating_module');
            if (is_array($activated)) {
                foreach ($activated as $activatedItem) {
                    $this->updateStatusHandler->deactivate($activatedItem);
                    $info .= 'Module ' . $activatedItem->getModuleName() . ' deactivated.';
                }
            } else {
                $this->updateStatusHandler->deactivate($activated);
                $info .= 'Module ' . $activated->getModuleName() . ' deactivated.';
            }
            $this->sessionRepo->forget('activating_module');
        }

        if ($this->sessionRepo->has('deactivating_module')) {
            $deactivated = $this->sessionRepo->get('activating_module');
            if (is_array($deactivated)) {
                foreach ($deactivated as $deactivatedItem) {
                    $this->updateStatusHandler->activate($deactivatedItem);
                    $info .= 'Module ' . $deactivatedItem->getModuleName() . ' reactivated.';
                }
            } else {
                $this->updateStatusHandler->activate($deactivated);
                $info .= 'Module ' . $deactivated->getModuleName() . ' reactivated.';
            }
            $this->sessionRepo->forget('deactivating_module');
        }

        $response = new ErrorLoadModuleResponse(
            $exception,
            $info
        );

        return $response;

    }
}
