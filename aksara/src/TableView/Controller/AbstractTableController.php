<?php

namespace Aksara\TableView\Controller;

use Illuminate\Http\Request;
use Aksara\TableView\Controller\Concerns;
use Aksara\TableView\TableRepository;
use Aksara\TableView\TablePresenter;

abstract class AbstractTableController
{
    use Concerns\HasDestroyAction;

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
        ){
            return $this->callAction($request);
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

        if ($request->input($this->table->getInputField('search')) &&
            $request->input($this->table->getInputField('bsearch'))
        ){
            $search = $request->input($this->table->getInputField('search'));
            $data = $this->repo->search($this->table->getSearchable(), $search, isset($data) ? $data : null);
        } else {
            $search = '';
        }

        if ($request->input($this->table->getInputField('view'))) {
            $filterValue = $request->input($this->table->getInputField('view'));
            $data = $this->callFilter($filterValue, isset($data) ? $data : null);
        }

        $total = $data->count();
        $data = $data->paginate(10);

        $this->table->setData($data);
        $this->table->setSearch($search);
        $this->table->setSort($sort, $order);
        $this->table->setParentUrl($request->url());
        $this->table->setRouteName($request->route()->getName());

        return $this->table;
    }

    private function callFilter($filterValue, $referenceModel = null)
    {
        //TODO
        //proper callback hook
        $callable = [$this, 'filter'.snake_to_camel($filterValue)];
        return $this->repo->filter($callable, $referenceModel);
    }

    private function callAction($request)
    {
        if ($request->input($this->table->getInputField('apply'))) {
            $apply = $request->input($this->table->getInputField('apply'));
            //TODO
            //proper callback hook
            $callable = [$this, 'action'.snake_to_camel($apply)];
            $callable($request);
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
}

