<?php

namespace App\Http\Controllers\Users;

use DB;
use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }

        $users = User::paginate(16);

        return view('users.users', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');
        $data = [
            'forms' => true,
            'pagetitle' => 'Add New User',
            'titles' => [(object)
                [
                'title' => 'New User Details',
                'icon' => 'fa fa-user',
                ],
            ],
            'wizard' => (object) [
                'form' => (object) [
                    'action' => route('users.save'),
                    'method' => 'post',
                ],
            ],
            'roles' => $roles,
        ];

        return view('users.create-user', $data);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param \App\Http\Requests\StoreUsersRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        DB::transaction(function () use ($request) {
            $user = User::create($request->all());
            $user->assign($request->input('role'));
            $user->person()->create($request->input());
        });

        return redirect()->route('users.index');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function show(User $user)
    {
        $forms = true;

        return view('users.user-sales', compact('user', 'forms'));
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showTimeline(User $user)
    {
        $forms = true;
        $timeline = $user->activity()->orderBy('created_at', 'DESC')->paginate();

        return view('users.timeline', compact('user', 'forms', 'timeline'));
    }

    /**
     * Show the form for editing User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');
        $pagetitle = trans('main.edit_user');

        return view('users.modals.edit-user-details', compact('user', 'roles', 'pagetitle'));
    }

    /**
     * Update User in storage.
     *
     * @param \App\Http\Requests\UpdateUsersRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->update($request->all());
        foreach ($user->roles as $role) {
            $user->retract($role);
        }
        foreach ($request->input('roles') as $role) {
            $user->assign($role);
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
