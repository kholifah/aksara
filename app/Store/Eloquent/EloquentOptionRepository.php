<?php
namespace App\Store\Eloquent;

use Aksara\Repository\OptionRepository;
use App\Models\Option;

class EloquentOptionRepository implements OptionRepository
{
    private $model;

    public function __construct(Option $model)
    {
        $this->model = $model;
    }

    public function getOptions($key = false, $default = null)
    {
        return $this->model->get_options($key, $default);
    }

    public function setOptions($key = false, $value = null)
    {
        return $this->model->set_options($key, $value);
    }
}

