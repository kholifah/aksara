<?php

namespace Aksara\TableView;

abstract class BasicTablePresenter implements TablePresenter
{
    private $data;
    private $search;
    protected $identifier = 'id';
    protected $inputPrefix = '';

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
