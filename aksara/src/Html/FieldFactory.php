<?php

namespace Aksara\Html;

use Aksara\Html\Fields\DateField;

class FieldFactory
{
    public function date($name, ?\DateTime $value = null, $attributes = [], $datePickerFormat = 'dd M yy', $dateFormat = 'd M Y')
    {
        $field = new DateField($name, $value, $attributes, $datePickerFormat, $dateFormat);
        $field->render();
    }
}
