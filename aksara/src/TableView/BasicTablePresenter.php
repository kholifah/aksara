<?php

namespace Aksara\TableView;

abstract class BasicTablePresenter
{
    private $data;
    private $search;
    protected $identifier = 'id';

    /**
     * array
     *
     * format [ 'column_name' => 'Column Label' ]
     */
    public abstract function getColumns();
    protected abstract function getEditUrl($identifier);
    protected abstract function getDeleteUrl($identifier);

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

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getColumnLabels()
    {
        return array_values($this->getColumns());
    }

    public function getColumnKeys()
    {
        return array_keys($this->getColumns());
    }

    public function getRows()
    {
        $rows = [];
        $keys = $this->getColumnKeys();

        //field attributes
        foreach ($this->data as $item) {
            $rowItem = [];
            $rowItem['id'] = $item->{$this->identifier};

            foreach ($keys as $key) {
                $rowItem['fields'][$key] = $item->$key;
            }

            $rowItem['url']['edit'] = $this->getEditUrl($item->{$this->identifier});
            $rowItem['url']['delete'] = $this->getDeleteUrl($item->{$this->identifier});

            $rows[] = $rowItem;
        }

        return $rows;
    }

    public function empty()
    {
        return $this->data->count() == 0;
    }

    public function paginationLinks()
    {
        return $this->data->links();
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function getTotal()
    {
        return $this->data->count();
    }

    public function render($viewName, $presenterName = 'table')
    {
        return view($viewName, [ $presenterName => $this ])->render();
    }
}
