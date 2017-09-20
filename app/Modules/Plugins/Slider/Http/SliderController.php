<?php
namespace App\Modules\Plugins\Slider\Http;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
  function index()
  {
    return view('plugin:slider::index');
  }

  function save()
  {
    return view('plugin:slider::index');
  }
}
