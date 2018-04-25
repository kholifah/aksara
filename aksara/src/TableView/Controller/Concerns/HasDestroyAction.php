<?php

namespace Aksara\TableView\Controller\Concerns;

trait HasDestroyAction
{
    //TODO dynamic function registration
    //this function should be paired with getBulkActionOptions currently in presenter
    protected function actionDestroy($request)
    {
        if ($request->input($this->table->getListIdentifier())) {
            $id = $request->input($this->table->getListIdentifier());
            $this->deleteMultiple($id);
        }
    }

    private function deleteMultiple(array $idList)
    {
        $count = count($idList);
        $success = $this->repo->delete($idList);
        if (!$success) {
            admin_notice('danger', $this->getFailedDeleteMessage());
            return false;
        }
        admin_notice('success', $this->getMultipleDeletedMessage($count));
    }

    protected function getMultipleDeletedMessage($count)
    {
        return trans_choice(
            'tableview.messages.multiple_deleted',
            $count, [ 'count' => $count ]
        );
    }

    protected function getFailedDeleteMessage()
    {
        return __('tableview.messages.delete_failed');
    }
}
