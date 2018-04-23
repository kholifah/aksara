<?php

namespace Aksara\TableView\Presenter;

use Aksara\TableView\TablePresenter;

abstract class BasicTablePresenter implements TablePresenter
{
    private $data;
    private $search;
    private $filtered = [];
    protected $identifier = 'id';
    protected $listIdentifier = 'id_list';
    protected $inputPrefix = '';
    protected $sort;
    protected $order;
    protected $parentUrl;
    protected $searchable = [];
    protected $sortable = [];
    protected $defaultSortColumn = 'id';
    protected $routeName = '';

    /**
     * array
     *
     * format [ 'column_name' => 'Column Label' ]
     */
    protected abstract function getColumns();
    protected function getEditUrl($identifier) { return false; }
    protected function getDeleteUrl($identifier) { return false; }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getListIdentifier()
    {
        return $this->listIdentifier;
    }

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getDefaultSortColumn()
    {
        return $this->defaultSortColumn;
    }

    /**
     * Eloquent paginated collection
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * plain string
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function setFiltered($filtered = [])
    {
        $this->filtered = $filtered ?? [];
    }

    public function setSort($sort, $order)
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    public function setParentUrl($url)
    {
        $this->parentUrl = $url;
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    public function getSortable()
    {
        return $this->sortable;
    }

    public function setSortable($sortable = [])
    {
        $this->sortable = $sortable;
    }

    protected function getColumnHeaders()
    {
        $valuesCopy = [];
        foreach ($this->getColumns() as $key => $value) {

            if (is_array($value)) {
                $label = $value['label'];
            } else {
                $label = $value;
            }

            $valuesCopy[] = $this->getHeader($key, $label);
        }
        return $valuesCopy;
    }

    private function getHeader($value, $label)
    {
        $sortable = $this->getSortable();
        if (in_array($value, $sortable) || array_key_exists($value, $sortable)) {
            $sort = [
                $this->getInputField('sort_by') => $value,
                $this->getInputField('sort_order') =>
                (strtoupper($this->order) == 'ASC' ? 'DESC' : 'ASC'),
            ];
            $params = $this->mergeParameters($sort);
            $query = http_build_query($params);
            $link = $this->parentUrl.'?'.$query;
            return "<a href='$link'>$label</a>";
        }
        return $label;
    }

    private function mergeParameters($query)
    {
        $search = [ $this->getInputField('search') => $this->search ];
        $merged = array_merge($query, $search);
        return $merged;
    }

    protected function getColumnLabels()
    {
        $values = array_values($this->getColumns());
        $valuesCopy = [];
        foreach ($values as $value) {
            if (is_array($value)) {
                $valuesCopy[] = $value['label'];
            } else {
                $valuesCopy[] = $value;
            }
        }
        return $valuesCopy;
    }

    protected function getColumnKeys()
    {
        return array_keys($this->getColumns());
    }

    private function hasColumnFormatter($key)
    {
        return isset($this->getColumns()[$key]['formatter']);
    }

    private function formatColumn($key, $value)
    {
        if (!$this->hasColumnFormatter($key)) {
            return $value;
        }
        $formatter = $this->getColumns()[$key]['formatter'];
        return $formatter($value);
    }

    protected function getRows()
    {
        $rows = [];
        $keys = $this->getColumnKeys();

        //field attributes
        foreach ($this->data as $item) {
            $rowItem = [];
            $rowItem['id'] = $item->{$this->identifier};

            foreach ($keys as $key) {
                $rowItem['fields'][$key] = $this->formatColumn($key, $item->$key);
            }

            $rowItem['url']['edit'] = $this->getEditUrl($item->{$this->identifier});
            $rowItem['url']['delete'] = $this->getDeleteUrl($item->{$this->identifier});

            $rows[] = $rowItem;
        }

        return $rows;
    }

    protected function empty()
    {
        return $this->data->count() == 0;
    }

    protected function paginationLinks()
    {
        return $this->data->links();
    }

    protected function getSearch()
    {
        return $this->search;
    }

    protected function getFiltered()
    {
        return $this->filtered;
    }

    protected function getTotal()
    {
        return $this->data->count();
    }

    public function getInputField($fieldName)
    {
        if (empty($this->inputPrefix)) {
            return $fieldName;
        }
        return $this->inputPrefix.'_'.$fieldName;
    }

    private $actions = [];

    private function baseRegisterActions()
    {
        $this->addAction('destroy', __('tableview.labels.delete'));
        $this->registerActions();
    }

    protected function registerActions() {}

    protected function addAction($name, $label)
    {
        $this->actions[$name] = $label;
    }

    private function baseRegisterFilters()
    {
        //TODO add base filter
        //hooks can also be registered here
        $this->registerFilters();
    }

    protected function registerFilters() {}

    public function render($viewName = 'table.basic', $presenterName = 'table')
    {
        $this->baseRegisterFilters();
        $this->baseRegisterActions();

        return view($viewName, [
            $presenterName => [
                'searchable' => empty($this->searchable) ? false : true,
                'rows' => $this->getRows(),
                'total' => $this->getTotal(),
                'pagination_links' => $this->paginationLinks(),
                'column_labels' => $this->getColumnLabels(),
                'column_headers' => $this->getColumnHeaders(),
                'search' => $this->getSearch(),
                'filtered' => $this->getFiltered(),
                'row_identifier' => $this->identifier,
                'list_identifier' => $this->listIdentifier,
                'inputs' => [
                    'search' => $this->getInputField('search'),
                    'bsearch' => $this->getInputField('bsearch'),
                    'apply' => $this->getInputField('apply'),
                    'bapply' => $this->getInputField('bapply'),
                    'filter' => $this->getInputField('filter'),
                    'bfilter' => $this->getInputField('bfilter'),
                ],
                'bulk_actions' => $this->actions,
            ],
        ])
        ->render();
    }
}

