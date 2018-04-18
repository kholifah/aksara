<?php

namespace Aksara\TableView;

use Illuminate\Http\Request;

abstract class AbstractTableController
{
    protected $repo;
    protected $defaultSortColumn = 'id';
    private $requestPrefix = '';

    public function __construct(
        TableRepository $repo,
        TablePresenter $table
    ){
        $this->repo = $repo;
        $this->table = $table;
    }

    private function getRequestField(Request $request, $field)
    {
        return $request->get($this->table->getInputField($field));
    }

    public function handle(Request $request)
    {
        if (
            $request->get($this->table->getInputField('bapply')) &&
            $request->get($this->table->getInputField('apply'))
        ) {
            return $this->apply($request);
        }

        $sort = $this->getRequestField($request, 'sort_by');
        $order = '';

        if ($sort) {
            $order = $this->getRequestField($request, 'sort_order');
            if (!$order) {
                $order = 'ASC';
            }
            $data = $this->repo->sort($sort, $order);
        } else {
            $data = $this->repo->sort($this->table->getDefaultSortColumn());
        }

        if ($request->input($this->table->getInputField('filter'))) {
            $filterValue = $request->input($this->table->getInputField('filter'));
            $data = $this->callFilter($filterValue, isset($data) ? $data : null);
        }

        if ($request->input($this->table->getInputField('search'))) {
            $search = $request->input($this->table->getInputField('search'));
            $data = $this->repo->search($this->table->getSearchable(), $search, isset($data) ? $data : null);
        } else {
            $search = '';
        }

        $total = $data->count();
        $data = $data->paginate(10);

        $this->table->setData($data);
        $this->table->setSearch($search);
        $this->table->setSort($sort, $order);
        $this->table->setParentUrl($request->url());

        return $this->table;
    }

    private function callFilter($filterValue, $referenceModel = null)
    {
        //TODO
        //proper callback hook
        $callable = [$this, 'filter'.snake_to_camel($filterValue)];
        return $this->repo->filter($callable, $referenceModel);
    }

    private function apply($request)
    {
        if ($request->input($this->table->getInputField('apply'))) {
            $apply = $request->input($this->table->getInputField('apply'));
            //TODO
            //proper callback hook
            $callable = [$this, 'action'.snake_to_camel($apply)];
            $callable($request);
            //$this->{'action'.snake_to_camel($apply)}($request);
        }
        //prevent delete repeating with refresh button
        //remove bapply, apply, then redirect
        //include other parameters
        return redirect()->back()->withInput(
            $request->except([
                $this->table->getInputField('bapply'),
                $this->table->getInputField('apply'),
            ])
        );
    }

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
        return __('tableview.messages.delete_failed');
    }
}

