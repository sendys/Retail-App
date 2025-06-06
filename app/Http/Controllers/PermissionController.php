<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        /* if (!auth()->user()->can('manage permission')) {
            abort(403, 'Anda tidak memiliki izin akses.');
        } */

        $query = Permission::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        $permissions = $query->orderBy('group')->orderBy('id')->paginate(10);

        return view('permission.index', compact('permissions'));
    }

    public function create()
    {
       /*  if (!auth()->user()->can('create permission')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        } */

        return view('permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'group' => 'nullable|string',
        ]);

        /* dd($request); */
        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission berhasil ditambahkan.');
    }

    public function edit($id)
    {
        /* if (!auth()->user()->can('edit permission')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        } */

        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission berhasil diubah.');
    }

    public function destroy($id)
    {
       /*  if (!auth()->user()->can('delete permission')) {
            abort(403, 'Anda tidak memiliki izin untuk menambah user.');
        } */
        
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission berhasil dihapus.');
    }
}
