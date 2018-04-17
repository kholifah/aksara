<?php

namespace Aksara\TableView;

abstract class BasicTablePresenter implements TablePresenter
{
    private $data;
    private $search;
    protected $identifier = 'id';
    protected $inputPrefix = '';
    protected $sort;
    protected $order;
    protected $parentUrl;
    private $sortable;

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

    public function setSort($sort, $order)
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    public function setParentUrl($url)
    {
        $this->parentUrl = $url;
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
        if (in_array($value, $this->sortable)) {
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

    public function render($viewName = 'basic_table', $presenterName = 'table')
    {
        return view($viewName, [
            $presenterName => [
                'rows' => $this->getRows(),
                'total' => $this->getTotal(),
                'links' => $this->paginationLinks(),
                'column_labels' => $this->getColumnLabels(),
                'column_headers' => $this->getColumnHeaders(),
                'search' => $this->getSearch(),
                'row_identifier' => $this->identifier,
                'inputs' => [
                    'search' => $this->getInputField('search'),
                    'apply' => $this->getInputField('apply'),
                    'bapply' => $this->getInputField('bapply'),
                ]
            ],
        ])
        ->render();
    }
}
