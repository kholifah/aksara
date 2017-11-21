<?php
namespace App\Modules\Plugins\PostType\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class OptionController extends Controller
{
    public function index()
    {
        $options = get_options('website_options', []);
        $pages = $this->generate_homepage_options();
        $postTypes = \Config::get('aksara.post-type.post-types');
        $permalink = \App::make('App\Modules\Plugins\PostType\Permalink');

        $options['custom_meta_header'] = !isset($options['custom_meta_header']) == '' ? $options['custom_meta_header'] :  '<meta name="author" content="" />' ;

        return view('plugin:post-type::option.index', compact('options','pages','postTypes','permalink'));
    }

    public function save(Request $request)
    {
        $data = $request->all();

        set_options('website_options', $data['options']);

        admin_notice('success', 'Data berhasil diubah.');
        return redirect()->route('aksara-post-type-option');
    }

    private function generate_homepage_options()
    {
        // Create Homepage Option
        $pages = [];
        $pages['default'] = 'home.blade.php';

        $pagesFromDB = \App\Modules\Plugins\PostType\Model\Post::where('post_status','publish')->where('post_type','page');
        $pagesFromDB = \Eventy::filter('aksara.post-type.front-end.option.pages-query', $pagesFromDB);

        $pagesFromDB = $pagesFromDB->get()->pluck('post_title','id');;

        foreach ( $pagesFromDB as $key => $val ) {
            $pages[$key] = $val;
        }

        return $pages;
    }
}
