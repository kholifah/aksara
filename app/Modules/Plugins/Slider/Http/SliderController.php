<?php
namespace App\Modules\Plugins\Slider\Http;

use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        return view('plugin:slider::index');
    }

    public function save()
    {
        return view('plugin:slider::index');
    }
}
