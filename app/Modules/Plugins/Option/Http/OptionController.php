<?php
namespace App\Modules\Plugins\Option\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class OptionController extends Controller
{

    function index()
    {
      $site_options = get_options('site_options',[]);

      return view('plugin:option::index',compact('site_options'));
    }

    function save(Request $request)
    {
        $data = $request->all();

        set_options('site_options', $data['options']);

        admin_notice('success', 'Data berhasil diubah.');
        return redirect()->route('aksara-option');

    }

}
