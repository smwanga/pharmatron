<?php

namespace App\Http\Controllers\Users;

use DB;
use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUsersRequest;

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
        $data = [
            'user' => $user,
            'forms' => true,
            'sales' => [
                'this_year' => $user->userSalesThisYear()->map(function ($sale) {
                    return $sale->total;
                })->sum(),
                'this_month' => $user->userSalesThisMonth()->map(function ($sale) {
                    return $sale->total;
                })->sum(),

                'today' => $user->userSalesToday()->map(function ($sale) {
                    return $sale->total;
                })->sum(),
            ],
        ];

        return view('users.user-sales', $data);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function showTimeline(User $user)
    {
        if (Gate::allows('users.manage') || $user->is_logged_in) {
            $forms = true;
            $timeline = $user->activity()->orderBy('created_at', 'DESC')->paginate();

            return view('users.timeline', compact('user', 'forms', 'timeline'));
        }

        return abort(401);
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
        if (!Gate::allows('users.manage') || !$user->is_logged_in) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');
        $pagetitle = trans('main.edit_user');

        return view('users.modals.edit-user-details', compact('user', 'roles', 'pagetitle'));
    }

    /**
     * Show the form for editing User password.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(User $user)
    {
        if (!$user->is_logged_in) {
            return abort(401);
        }
        $pagetitle = 'Change Auth Password';

        return view('users.modals.change-pass', compact('user', 'pagetitle'));
    }

    /**
     * Show the form for editing User password.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        if (!auth()->user()->id === $user->id) {
            return abort(401);
        }
        $this->validate($request, ['new_password' => 'required|confirmed|min:6']);
        if (password_verify($request->get('current_pass'), $user->password)) {
            $user->update(['password' => $request->get('new_password')]);

            return ['stutus' => 'success', 'message' => 'Password updated'];
        }

        return response(['current_pass' => ['The password provided does not match any record']], 422);
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
        $user->person()->updateOrCreate(['id' => $user->id], $request->input());
        $user->update($request->input());
        foreach ($user->roles as $role) {
            $user->retract($role);
        }
        $user->assign($request->input('role'));
        if ($request->wantsJson()) {
            return ['status' => 'success', 'message' => 'User details Updated', 'data' => [$user, $request->input()]];
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!Gate::allows('users.manage')) {
            return abort(401);
        }
        if (auth()->user()->id == $user->id) {
            return ['staus' => 'error', 'message' => 'Cant delete your own account'];
        }
        $user->delete();

        return redirect()->route('users.index');
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
