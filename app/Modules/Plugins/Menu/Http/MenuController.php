<?php

namespace App\Modules\Plugins\Menu\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class MenuController extends Controller
{

    function index()
    {
      $menus = get_registered_menu();

      if( sizeof( $menus ) == 0 )
        return view('menu::empty');

      $menu_active_id = key($menus);
      return view('plugin:menu::index',compact('menus','menu_active_id'));
    }

    function save(Request $request)
    {
        $data = $request->all();

        if(isset($data['menu_data']))
        {
            set_options('aksara.menu.menus',$data['menu_data']);
            admin_notice('success', 'Menu berhasil di-update.');
        }
        return redirect(route('aksara-menu'). '#');
    }

}
