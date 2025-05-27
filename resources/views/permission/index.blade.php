@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Daftar Permissions</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('permission.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau grup..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Cari</button>
            <a href="{{ route('permission.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Tombol Tambah --}}
    <a href="{{ route('permission.create') }}" class="btn btn-success mb-3">+ Tambah Permission</a>

    {{-- Table Grouped --}}
    @forelse ($permissions->groupBy('group') as $group => $items)
        <h5 class="mt-4">{{ $group ?? 'Tanpa Group' }}</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Guard</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST"
                                  style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p class="text-muted">Tidak ada permission ditemukan.</p>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $permissions->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection