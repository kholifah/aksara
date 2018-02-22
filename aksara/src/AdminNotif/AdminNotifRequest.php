<?php
namespace Aksara\AdminNotif;

class AdminNotifRequest
{
    private $labelClass;
    private $content;

    public function __construct(string $labelClass, string $content)
    {
        $this->labelClass = $labelClass;
        $this->content = $content;
    }

    public function getLabelClass() : string
    {
        return $this->labelClass;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function toArray() : array
    {
        return [
            'labelClass' => $this->labelClass,
            'content' => $this->content,
        ];
    }
}
