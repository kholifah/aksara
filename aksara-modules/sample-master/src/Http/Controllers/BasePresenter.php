<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Plugins\SampleMaster\Repositories\RepositoryInterface;

abstract class BasePresenter
{
    protected $repo;
    protected $request;
    protected $searchable = [];
    protected $defaultSortColumn = 'id';

    public function __construct(RepositoryInterface $repo, Request $request)
    {
        $this->repo = $repo;
        $this->request = $request;
    }

    public function index($viewName)
    {
        if ($this->request->get('bapply')) {
            return $this->apply();
        }

        $data = $this->repo->sort($this->defaultSortColumn);
        if ($this->request->input('search')) {
            $search = $this->request->input('search');
            foreach ($this->searchable as $field) {
                $data = $data->orWhere($field, 'like', '%' . $search . '%');
            }
        } else {
            $search = '';
        }

        $total = $data->count();
        $data = $data->paginate(10);
        return view($viewName, compact('data', 'search', 'total'));
    }

    private function apply()
    {
        if ($this->request->input('apply')) {
            $apply = $this->request->input('apply');
            if ($apply == 'destroy') {
                $this->applyDelete();
            }
        }
        //prevent delete repeating with refresh button
        //remove bapply, apply, then redirect
        //include other parameters
        return redirect()->back()->withInput(
            $this->request->except([ 'bapply', 'apply' ])
        );
    }

    private function applyDelete()
    {
        if ($this->request->input('id')) {
            $id = $this->request->input('id');
            $this->deleteMultiple($id);
        }
    }

    private function deleteMultiple(array $idList)
    {
        foreach ($idList as $id) {
            $success = $this->deleteSupplier($id);
        }
        $count = count($idList);
        admin_notice('success', $this->getMultipleDeletedMessage($count));
    }

    private function deleteSupplier($id)
    {
        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', $this->getFailedDeleteMessage());
            return false;
        }
        return true;
    }

    protected function find($id)
    {
        $data = $this->repo->find($id);
        if (!$data) {
            abort(404, 'Page Not Found');
        }
        return $data;
    }

    protected function getMultipleDeletedMessage($count)
    {
        return "$count item(s) deleted";//TODO global language
    }

    protected function getFailedDeleteMessage()
    {
        return 'Failed to delete data';//TODO global language
    }

    public abstract function create($viewName);

    public abstract function edit($id, $viewName);
}
