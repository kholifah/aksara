<?php

namespace Aksara\Html\Fields;

class DateField
{
    private $attributes = [];

    private $value;
    private $name;

    private $datePickerFormat;
    private $dateFormat;

    public function __construct($name, ?\DateTime $value = null, $attributes = [], $datePickerFormat = 'dd M yy', $dateFormat = 'd M Y')
    {
        $this->name = $name;
        $this->value = $value;
        $this->attributes = $attributes;
        $this->datePickerFormat = $datePickerFormat;
        $this->dateFormat = $dateFormat;
    }

    public function render()
    {
        echo $this->buildDatePicker();
        echo $this->buildInput();
        $this->enqueueScript();
    }

    private function buildInput()
    {
        $value = is_null($this->value) ? null : $this->value->format('Y-m-d');
        $input = '<input type="hidden" name="'.$this->name.'" id="'.$this->getInputId().'"  value="'.$value.'">';
        return $input;
    }

    private function buildDatePicker()
    {
        $attributes = $this->buildDatePickerAttributes();
        $picker = '<input type="text" '.$attributes.'>';
        return $picker;
    }

    private function buildDatePickerAttributes()
    {
        $standardAttributes = [];

        $standardAttributes['style'] = @$this->attributes['style'] ?? 'position: relative; z-index: 100000;';
        $standardAttributes['id'] = $this->getDisplayId();
        $standardAttributes['value'] = is_null($this->value) ? null : $this->value->format($this->dateFormat);

        $attributes = array_merge($standardAttributes, $this->attributes);

        return $this->buildAttributeString($attributes);
    }

    private function buildAttributeString($attributes)
    {
        $attributeString = '';

        foreach ($attributes as $key => $value) {
            $attributeString .= $key.'="'.$value.'" ';
        }
        return $attributeString;
    }

    private function enqueueScript()
    {
        $script = '
            $(function() {
                $("#'.$this->getDisplayId().'").datepicker({
                    dateFormat: "'.$this->datePickerFormat.'",
                    altField: "#'.$this->getInputId().'",
                    altFormat: "yy-mm-dd"
                });
                $("#'.$this->getDisplayId().'").change(function(){
                    dateString = $(this).val();
                    parsed = Date.parse(dateString);
                    if(!parsed) {
                        $("#'.$this->getDisplayId().'").datepicker("setDate", null);
                    }
                });
            });
        ';
        \AssetQueue::enqueueInlineScript(
            'admin',
            $script,
            $this->getDisplayId().'-script',
            10,
            true
        );
    }

    private function getDisplayId()
    {
        return $this->name . '-picker';
    }

    private function getInputId()
    {
        return $this->name . '-input';
    }


}
