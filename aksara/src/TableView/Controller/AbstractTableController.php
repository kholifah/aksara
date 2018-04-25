<?php

namespace Aksara\TableView\Controller;

use Illuminate\Http\Request;
use Aksara\TableView\Controller\Concerns;
use Aksara\TableView\TableRepository;
use Aksara\TableView\TablePresenter;
use Carbon\Carbon;

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

        $data = null;

        if ($sort) {
            $order = $this->getRequestField($request, 'sort_order');
            if (!$order) {
                $order = 'ASC';
            }
            $data = $this->callSort($sort, $order, $data);
        } else {
            $data = $this->repo->sort($this->table->getDefaultSortColumn());
        }

        $filters = [];

        if (($this->getRequestField($request, 'filter')) &&
            ($this->getRequestField($request, 'bsearch') ||
            $this->getRequestField($request, 'bfilter'))
        ){
            $filters = $request->input($this->table->getInputField('filter'));
            foreach ($filters as $filterValue) {
                if (empty($filterValue)) {
                    continue;
                }
                $data = $this->callFilter($filterValue, isset($data) ? $data : null);
            }
        }

        $columnFilterValues = [];

        //format:
        //[ 'column_name' => 'label' ]
        $columnFilters = $this->table->getColumnFilters();
        $columnFilterValues = [];

        foreach (array_keys($columnFilters) as $columnName) {
            if (($this->getRequestField($request, $columnName.'_filter')) &&
                ($this->getRequestField($request, 'bsearch') ||
                $this->getRequestField($request, 'bfilter'))
            ){
                $columnFilterValue = $this->getRequestField($request, $columnName.'_filter');
                $data = $this->repo->filterColumn($columnName, $columnFilterValue, $data);
                $columnFilterValues[$columnName] = $columnFilterValue;
            }
        }

        $dateRangeFilters = $this->table->getDateRangeFilters();
        $dateRangeFilterValues = [];

        foreach ($dateRangeFilters as $columnName) {
            $fromDate = Carbon::minValue();

            if (($this->getRequestField($request, $columnName.'_filter_from')) &&
                ($this->getRequestField($request, 'bsearch') ||
                $this->getRequestField($request, 'bfilter'))
            ){
                $fromDate = Carbon::parse($this->getRequestField($request, $columnName.'_filter_from'));
            }

            $toDate = Carbon::maxValue();

            if (($this->getRequestField($request, $columnName.'_filter_to')) &&
                ($this->getRequestField($request, 'bsearch') ||
                $this->getRequestField($request, 'bfilter'))
            ){
                $toDate = Carbon::parse($this->getRequestField($request, $columnName.'_filter_to'));
            }

            $data = $this->repo->between($columnName, $fromDate, $toDate, $data);
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
        $this->table->setFiltered($filters);
        $this->table->setColumnFiltered($columnFilterValues);
        $this->table->setSort($sort, $order);
        $this->table->setParentUrl($request->url());
        $this->table->setRouteName($request->route()->getName());

        return $this->table;
    }

    private function callSort($column, $order, $referenceModel = null)
    {
        //TODO
        //if callable, use callable to sort data
        $callback = $this->getColumnSortCallable($column);
        if ($callback != false) {
            return $this->repo->sortCallback($callback, $order, $referenceModel);
        }
        //if column, use ordinary sort
        if (is_string($column)) {
            return $this->repo->sort($column, $order, $referenceModel);
        }
        throw new \Exception('Unsupported sort parameter');
    }

    private function getColumnSortCallable($column)
    {
        $sortable = $this->table->getSortable();
        if (isset($sortable[$column])) {
            if (is_callable($sortable[$column])) {
                return $sortable[$column];
            }
        }
        return false;
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

