<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('group', 'like', "%{$search}%");
        }

        $permissions = $query->orderBy('group')->paginate(5);

        return view('permission.index', compact('permissions', 'search'));
    }


    public function create()
    {
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'group' => 'nullable|string',
        ]);

        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permission.create')->with('success', 'Permission berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
            'group' => 'nullable|string',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'group' => $request->group,
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission berhasil diubah.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission berhasil dihapus.');
    }
}
