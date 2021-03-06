<?php
namespace Plugins\AksaraMultiBas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class OptionController extends Controller
{
    public function index()
    {
        // Enqueue CSS
        if(env('APP_ENV')=='local') {
            aksara_admin_enqueue_script("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js", "vue" , 20, true);
        }
        else {
            aksara_admin_enqueue_script("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.min.js", "vue" , 20, true);
        }

        multibas_admin_enqueue_script('js/script.js', 'multibas-script', 25, true);
        multibas_admin_enqueue_style('css/flag-icon.min.css', 'flag-icon', 25, true);

        $countries = get_registered_locales();
        $lang_options = get_country_code();
        $lang_options =  json_encode($lang_options);

        return view('aksara-multi-bas::option', compact('countries','lang_options'));
    }

    public function save(Request $request)
    {
        $data = $request->all();

        set_options('multibas_countries', $data['countries']);

        admin_notice('success', __('aksara-multi-bas::message.success-message'));
        return redirect()->route('aksara-multibas-option');
    }
}
