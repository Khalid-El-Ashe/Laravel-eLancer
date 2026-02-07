<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'roles.index',
            ['roles' => Role::withCount('users')->paginate()]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create', ['role' => new Role]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'abilities' => ['required', 'array']
        ]);
        $role = Role::create($request->all());
        return to_route('roles.index')->with('success', __('Role is Added!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {

        $request->validate([
            'name' => 'required',
            'abilities' => ['required', 'array']
        ]);
        $role->update($request->all());
        return to_route('roles.index')->with('success', __('Role is Updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return to_route('roles.index')->with('success', 'Role is Deleted!');
    }
}
