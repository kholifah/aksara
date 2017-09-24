<?php

namespace App\Modules\Plugins\User\Http;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use Auth;

class UserController extends Controller {

    public function __construct() {
     //   $this->authorize('user');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $users = User::orderBy('name');
        if ($request->get('bapply')) {
            if ($request->input('apply')) {
                $apply = $request->input('apply');
                if ($apply == 'destroy') {
                    if ($request->input('user_id')) {
                        $user_id = $request->input('user_id');
                        foreach ($user_id as $v) {
                            $this->destroy($v);
                        }
                    }
                }
            }
        }
        if ($request->input('search')) {
            $search = $request->input('search');
            $users = $users->where('name', 'like', '%' . $search . '%');
        } else {
            $search = '';
        }

        $total = $users->count();
        $users = $users->paginate(10);
        return view('plugin:user::user.index', compact('users', 'search', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = new User();
        $user_role = Role::orderBy('name')->get()->pluck('name', 'name');
        return view('plugin:user::user.create', compact('user', 'user_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = new User();

        // $validator = $user->validate($request->all(), false);
        //
        // if ($validator->fails()) {
        //     foreach ($validator->messages()->toArray() as $v) {
        //         admin_notice('danger', $v[0]);
        //     }
        //     return redirect('admin/user/create')
        //                     ->withErrors($validator)
        //                     ->withInput();
        // }
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->role = $data['role'];
        $user->active = $data['active'];
        $user->save();
        admin_notice('success', 'Data berhasil ditambah.');
        return redirect()->route('aksara-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $user_role = Role::orderBy('name')->get()->pluck('name', 'name');
        return view('plugin:user::user.edit', compact('user', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $user = User::find($id);

        if ($request->input('password') || $request->input('password_confirmation'))
            $data = [
                'id' => $id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'role' => $request->input('role'),
                'active' => $request->input('active')
            ];
        else
            $data = [
                'id' => $id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'active' => $request->input('active')
            ];

        // $validator = $user->validate($data, false);
        //
        // if ($validator->fails()) {
        //     foreach ($validator->messages()->toArray() as $v) {
        //         admin_notice('danger', $v[0]);
        //     }
        //     return redirect('admin/user/' . $id . '/edit')
        //                     ->withErrors($validator)
        //                     ->withInput();
        // }

        if (isset($data['name']))
            $user->name = $data['name'];
        if (isset($data['email']))
            $user->email = $data['email'];
        if (isset($data['password']))
            $user->password = $data['password'];
        if (isset($data['role']))
            $user->role = $data['role'];
        if (isset($data['active']))
            $user->active = $data['active'];
        $user->save();
        admin_notice('success', 'Data berhasil diubah.');
        return redirect()->route('aksara-user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::find($id);
        if ($id != Auth::user()->id)
            if ($user->delete())
                admin_notice('success', 'Data berhasil dihapus.');
            else
                admin_notice('danger', 'Data gagal dihapus.');
        return redirect()->route('aksara-user');
    }

}
