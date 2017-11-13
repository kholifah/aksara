<?php
namespace App\Aksara\Core;
use \App\Aksara\Lib\BootstrapThreePresenter;

class CPaginate extends BootstrapThreePresenter
{
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<span class="pagination-links">%s %s %s %s %s</span>',
                $this->getFirst(),
                $this->getButtonPre(),
                $this->getCurrent(),
                $this->getButtonNext(),
                $this->getLast()
            );
        }
        return "";
    }

    public function getLast()
    {
        $url = $this->paginator->url($this->paginator->lastPage());
        if ($this->paginator->lastPage() == $this->paginator->currentPage()) {
            return $btn = ' <span class="tablenav-pages-navspan" aria-hidden="true">»</span>';
        }
        return $btn = ' <a class="next-page" href="'.$url.'"><span class="" aria-hidden="true">»</span></a>';
    }

    public function getFirst()
    {
        $url = $this->paginator->url(1);
        if (1 == $this->paginator->currentPage()) {
            return $btn = '<span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
        }
        return $btn = '<a class="next-page " href="'.$url.'"><span class="" aria-hidden="true">«</span></a>';
    }

    public function getCurrent()
    {
        $last = $this->paginator->lastPage();
        $current = $this->paginator->currentPage();
        return $btn = '<span id="table-paging" class="paging-input">'.$current.' of <span class="total-pages">'.$last.'</span></span>';
    }

    public function getButtonPre()
    {
        $url = $this->paginator->previousPageUrl();
        if (empty($url)) {
            return $btn = '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
        }
        return $btn = '<a class="next-page" href="'.$url.'"><span class="" aria-hidden="true">‹</span></a>';
    }

    public function getButtonNext()
    {
        $url = $this->paginator->nextPageUrl();
        if (empty($url)) {
            return $btn = '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
        }
        return $btn = '<a class="next-page" href="'.$url.'"><span aria-hidden="true">›</span></a>';
    }
}
