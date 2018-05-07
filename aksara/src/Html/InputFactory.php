<?php

namespace Aksara\Html;

use Aksara\Html\Inputs\DateInput;

class InputFactory
{
    public function date($name, ?\DateTime $value = null, $attributes = [], $datePickerFormat = 'dd M yy', $dateFormat = 'd M Y')
    {
        $field = new DateInput($name, $value, $attributes, $datePickerFormat, $dateFormat);
        $field->render();
    }
}
