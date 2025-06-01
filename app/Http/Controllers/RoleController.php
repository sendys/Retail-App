<?php

namespace App\Http\Controllers;

/* use App\Models\Role; */

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('manage role')) {
            abort(403, 'Anda tidak memiliki izin akses.');
        }

        $query = Role::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $roles = $query->paginate(request('per_page', 10)); // Paginate with 10 items per page

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create role')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        }

        $permissions = Permission::all()->groupBy('group');
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        // Assign permission jika ada
        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'redirect_url' => route('roles.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->can('edit role')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        }

        $permissions = Permission::all()->groupBy('group');
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        // Sync permissions (optional)
        $role->syncPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'redirect_url' => route('roles.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->can('delete role')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
