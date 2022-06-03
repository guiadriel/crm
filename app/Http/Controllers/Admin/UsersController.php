<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access users|create users|update users|delete users', ['only' => ['index', 'store']]);
        $this->middleware('permission:create users', ['only' => ['create', 'store']]);
        $this->middleware('permission:update users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('filter')) {
            $users = User::where('name', 'like', '%'.request('filter').'%')
                ->orWhere('email', 'like', '%'.request('filter').'%')
                ->paginate(15)
                ->appends('filter', request('filter'))
            ;
        } else {
            $users = User::paginate(15);
        }

        return view('admin.users.index')->with(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(User $user)
    {
        $user->password = $user->email;
        if ($user->save()) {
            request()->session()->flash('success', 'Senha resetada com sucesso!');
        }

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // if (Gate::denies('edit-users')) {
        //     return redirect(route('users.index'));
        // }
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $user->name = $request->username;
        $user->email = $request->email;
        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index');
    }
}
