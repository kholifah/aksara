<?php

namespace Aksara\TableView;

use Illuminate\Http\Request;

abstract class BasicTableController
{
    protected $repo;
    protected $searchable = [];
    protected $defaultSortColumn = 'id';
    private $redirecting = false;

    public function __construct(
        TableRepository $repo,
        BasicTablePresenter $table
    ){
        $this->repo = $repo;
        $this->table = $table;
    }

    public function handle(Request $request)
    {
        if ($request->get('bapply')) {
            return $this->apply($request);
        }

        $data = $this->repo->sort($this->defaultSortColumn);
        if ($request->input('search')) {
            $search = $request->input('search');
            foreach ($this->searchable as $field) {
                $data = $data->orWhere($field, 'like', '%' . $search . '%');
            }
        } else {
            $search = '';
        }

        $total = $data->count();
        $data = $data->paginate(10);

        $this->table->setData($data);
        $this->table->setSearch($search);
        return $this->table;
    }

    public function isRedirecting()
    {
        return $this->redirecting;
    }

    private function apply($request)
    {
        if ($request->input('apply')) {
            $apply = $request->input('apply');
            if ($apply == 'destroy') {
                $this->applyDelete($request);
            }
        }
        //prevent delete repeating with refresh button
        //remove bapply, apply, then redirect
        //include other parameters
        $this->redirecting = true;
        return redirect()->back()->withInput(
            $request->except([ 'bapply', 'apply' ])
        );
    }

    private function applyDelete($request)
    {
        if ($request->input('id')) {
            $id = $request->input('id');
            $this->deleteMultiple($id);
        }
    }

    private function deleteMultiple(array $idList)
    {
        foreach ($idList as $id) {
            $success = $this->delete($id);
        }
        $count = count($idList);
        admin_notice('success', $this->getMultipleDeletedMessage($count));
    }

    private function delete($id)
    {
        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', $this->getFailedDeleteMessage());
            return false;
        }
        return true;
    }

    private function find($id)
    {
        $data = $this->repo->find($id);
        if (!$data) {
            abort(404, 'Page Not Found');
        }
        return $data;
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
        return __('tableview.messages.failed_delete');
    }
}
