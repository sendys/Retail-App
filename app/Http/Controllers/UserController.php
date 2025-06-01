<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('manage user')) {
            abort(403, 'Anda tidak memiliki izin akses.');
        }

        $query = User::query();

        if ($request->has('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                // Base search conditions
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm);
            });
        }

        // Filter hasil untuk user biasa (tanpa melihat admin)
        if (auth()->user()->hasRole('user')) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'admin');
            });
        }

        $users = $query->paginate(10); // Paginate with 10 items per page

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create user')) {
            return redirect()->route('user.index')->with('error', 'Anda tidak memiliki izin untuk menambah user.');
        }
        
        $roles = Role::pluck('name', 'name')->all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         // Cek manual jika diperlukan:
        if (!auth()->user()->can('edit user')) {
            return redirect()->route('user.index')->with('error', 'Anda tidak memiliki izin untuk edit user.');
        }
        
        // Tambahan: user hanya boleh edit dirinya sendiri
        if (!auth()->user()->hasRole('admin') && auth()->id() !== (int) $id) {
            return redirect()->route('user.index')->with('error', 'Anda hanya bisa mengedit akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name'); // nama role sebagai value & label
        $userRole = $user->getRoleNames()->toArray(); // ambil role user

        $userPermissions = $user->getPermissionNames()->toArray();
        $permissions = Permission::all()->groupBy('group');

        return view('user.edit', compact('user', 'roles', 'userRole', 'permissions', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' =>'required|numeric',
            'company_name' =>'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'roles' => 'required|array',
            'permissions' => 'nullable|array',
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company_name = $request->company_name;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync roles
        $user->syncRoles($request->roles);

        // Sync permissions (optional)
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cegah user menghapus dirinya sendiri
        if (auth()->user() == $user) {
            return redirect()->route('user.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        // Cek manual jika diperlukan:
        if (!auth()->user()->can('delete user')) {
            return redirect()->route('user.index')->with('error', 'Anda tidak memiliki izin untuk menghapus user.');
        }

        // Cegah user menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully');
    }

    public function register()  {
        return view('user.register');
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'phone' => 'required|numeric',
            'company_name' =>'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'company_name' => $request->company_name,
        ]);

        /* $user->assignRole($request->input('user')); */
        $user->syncRoles(['user']);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }
}
