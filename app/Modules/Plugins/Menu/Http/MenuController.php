<?php

namespace App\Modules\Plugins\Menu\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class MenuController extends Controller
{
    public function index()
    {
        $menus = get_registered_menu();

        aksara_admin_enqueue_style(url("assets/modules/Plugins/Menu/assets/menu.css"));

        if (sizeof($menus) == 0) {
            return view('menu::empty');
        }

        $menu_active_id = key($menus);
        return view('plugin:menu::index', compact('menus', 'menu_active_id'));
    }

    public function save(Request $request)
    {
        $data = $request->all();

        if (isset($data['menu_data'])) {
            foreach ($data['menu_data'] as $key => $value) {
                // Remove 'display'
                $data['menu_data'][$key] = json_decode($data['menu_data'][$key], true);
                $data['menu_data'][$key] = array_delete_recursive($data['menu_data'][$key], function ($value, $key) {
                    if ($key == 'display') {
                        return true;
                    }
                    return false;
                });
                $data['menu_data'][$key] = json_encode($data['menu_data'][$key]);
            }

            set_options('aksara.menu.menus', $data['menu_data']);
            admin_notice('success', 'Menu berhasil di-update.');
        }
        return redirect(route('aksara-menu'). '#');
    }
}
