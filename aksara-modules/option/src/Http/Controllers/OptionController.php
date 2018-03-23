<?php
namespace Plugins\Option\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class OptionController extends Controller
{
    public function index()
    {
        $site_options = get_options('site_options', []);
        $lang_options = get_country_code();
        $lang_options = $lang_options->pluck('name','language_code');

        return view('option::index', compact('site_options','lang_options'));
    }

    public function save(Request $request)
    {
        $data = $request->all();

        set_options('site_options', $data['options']);

        admin_notice('success', __('option::validation.success_save_option'));
        return redirect()->route('aksara-option');
    }
}
