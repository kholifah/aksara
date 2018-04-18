<?php

namespace Aksara\TableView;

class BulkAction
{
    private $name;
    private $label;
    private $callback;

    public function __construct($name, $label, $callback)
    {
        $this->name = $name;
        $this->label = $label;
        $this->callback = $callback;
    }

    public function getOption()
    {
        return [ $this->name => $this->label ];
    }
}
