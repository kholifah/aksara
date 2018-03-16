<?php
namespace Plugins\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Plugins\User\Models\Role;
use Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        //    $this->authorize('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('name');
        if ($request->get('bapply')) {
            if ($request->input('apply')) {
                $apply = $request->input('apply');
                if ($apply == 'destroy') {
                    if ($request->input('role_id')) {
                        $role_id = $request->input('role_id');
                        foreach ($role_id as $v) {
                            $this->destroy($v);
                        }
                    }
                }
            }
        }
        if ($request->input('search')) {
            $search = $request->input('search');
            $roles = $roles->where('name', 'like', '%' . $search . '%');
        } else {
            $search = '';
        }

        $total = $roles->count();
        $roles = $roles->paginate(10);

        return view('plugin:user::role.index', compact('roles', 'search', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role();
        $role->permissions = [];
        $capabilities = \RoleCapability::all();
        return view('plugin:user::role.create', compact('role', 'capabilities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();

        $validator = $role->validate($request->all(), false);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return redirect()->route('aksara-role-create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $data = $request->all();
        $role->name = $data['name'];
        $role->permissions = $data['permissions'];
        $role->save();
        admin_notice('success', 'Data berhasil ditambah.');
        return redirect()->route('aksara-role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $capabilities = \RoleCapability::all();
        return view('plugin:user::role.edit', compact('role', 'capabilities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $validator = $role->validate($request->all(), false);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return redirect()->route('aksara-role-create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $data = $request->all();
        $role->name = $data['name'];
        $role->permissions = $data['permissions'];
        $role->save();
        admin_notice('success', 'Data berhasil diubah.');
        return redirect()->route('aksara-role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role->delete()) {
            admin_notice('success', 'Data berhasil dihapus.');
        } else {
            admin_notice('danger', 'Data gagal dihapus.');
        }
        return redirect()->route('aksara-role');
    }
}
