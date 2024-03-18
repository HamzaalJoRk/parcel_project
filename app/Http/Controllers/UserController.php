<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Show-Users') || $userAuth->hasRole('SuperAdmin')) {
            $userCount = User::count();
            return view('admin.users.index')->with('userCount', $userCount);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }
    public function getUsers()
    {
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Show-Users') || $userAuth->hasRole('SuperAdmin')) {
            $users = User::with('roles')->get();
            return response()->json(['data' => $users]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Create-Users') || $userAuth->hasRole('SuperAdmin')) {
            $roles = Role::get();
            return view('admin.users.create', ['roles'=>$roles]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Create-Users') || $userAuth->hasRole('SuperAdmin')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ]);

            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user->save();

            if ($request->has('role') && $request->input('role') != null) {
                $role = Role::findOrFail($request->input('role'));
                $user->assignRole($role->name);
            }

            return redirect()->route('users.index')->with('success', 'User added successfully');
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
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
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Edit-Users') || $userAuth->hasRole('SuperAdmin')) {
            $user = User::findOrFail($id);
            $roles = Role::get();
            return view('admin.users.edit', compact('user', 'roles'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
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
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Edit-Users') || $userAuth->hasRole('SuperAdmin')) {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }

            if ($request->has('role') && $request->input('role') != null) {
                $role = Role::findOrFail($request->input('role'));
                $user->syncRoles([$role->name]);
            } else {
                $user->syncRoles([]);
            }

            return redirect()->route('users.index')->with('success', 'User information updated successfully');
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userAuth = auth()->user();
        if ($userAuth->hasPermissionTo('Delete-Users') || $userAuth->hasRole('SuperAdmin')) {
            $user = User::findOrFail($id);
            if($user->id == '1')
            {
                return response()->json(['error' => 'You cannot delete this user'], 422);
            }
            else{
                $user->delete();
                return response()->json(['success' => 'User deleted successfully'], 200);
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }

    }
}
