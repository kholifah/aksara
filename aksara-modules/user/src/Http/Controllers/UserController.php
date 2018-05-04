<?php

namespace Plugins\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Auth;
use Plugins\User\Presenters\UserForm;
use Plugins\User\Http\Requests\AddRoleUserRequest;
use Plugins\User\Repository\UserRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $repo, UserForm $form)
    {
        $this->repo = $repo;
        $this->form = $form;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        authorize('list-user');

        $users = User::orderBy('name');
        if ($request->get('bapply')) {
            if ($request->input('apply')) {
                $apply = $request->input('apply');
                if ($apply == 'destroy') {
                    if ($request->input('user_id')) {
                        $id = $request->input('user_id');
                        $this->destroy($id);
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
        return view('user::user.index', compact('users', 'search', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize('add-user');

        $user = new User();
        $user_role = Role::orderBy('name')->get()->pluck('name', 'name');
        return view('user::user.create', compact('user', 'user_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        authorize('add-user');

        $user = new User();

        $validator = $user->validate($request->all(), false);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->active = $data['active'];
        $user->save();
        admin_notice('success', __('user::messages.success_add_user'));
        return redirect()->route('aksara-user-edit', $user->id);
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
    public function edit($id, Request $request)
    {
        authorize('edit-user');

        $viewData = $this->form->edit($id, $request);
        if (!$viewData) {
            abort(404, 'Not found');
        }
        if ($viewData instanceof RedirectResponse) {
            return $viewData;
        }
        return view('user::user.edit', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        $user = \Auth::user();
        $user_role = Role::orderBy('name')->get()->pluck('name', 'name');
        return view('user::user.edit-profile', compact('user', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = false)
    {
        if ($id !== false) {
            authorize('edit-user');
        }

        $id === false ? $id = \Auth::user()->id : $id;

        $user = User::find($id);

        if ($request->input('password') || $request->input('password_confirmation')) {
            $data = [
                'id' => $id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'active' => $request->input('active')
            ];
        } else {
            $data = [
                'id' => $id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'active' => $request->input('active')
            ];
        }

         $validator = $user->validate($data, false);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        if (isset($data['active'])) {
            $user->active = $data['active'];
        }
        $user->save();
        admin_notice('success', __('user::messages.success_update_user'));

        if ($id === false) {
                return redirect()->route('aksara.user.edit-profile');
        }

        return redirect()->route('aksara-user-edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize('delete-user');

        if(!is_array($id)){
            $id = [$id];
        }

        foreach ($id as $userID) {
            $user = User::find($userID);
            if ($userID != Auth::user()->id) {
                if (!$user->delete()) {
                    admin_notice('danger', 'Data gagal dihapus.');
                }
            }
        }
        admin_notice('success', count($id).' data berhasil dihapus. ');
        return redirect()->route('aksara-user');
    }

    public function addRole($id, AddRoleUserRequest $request)
    {
        authorize('add-user-role');

        $roleId = $request->input('role_id');
        $success = $this->repo->attachOnce($id, 'roles', $roleId);
        if (!$success) {
            admin_notice('danger', __('user::messages.add_role_failed'));
        } else {
            admin_notice('success', __('user::messages.add_role_success'));
        }
        return redirect()->route('aksara-user-edit', $id);
    }
}
