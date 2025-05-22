@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Roles';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        {{--  <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Role Baru</h4>
                    <p class="sub-header">
                        Set heights using classes like <code>.input-lg</code>, and set widths using grid
                        column classes like <code>.col-lg-*</code>.
                    </p>
                    <form method="POST" action="{{ route('roles.store') }}" class="parsley-examples">
                        @csrf
                    
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Role<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" parsley-trigger="change" required
                                placeholder="Nama role baru" class="form-control" />
                        </div>
                    
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="guard_name" name="guard_name" required data-toggle="select2" data-width="100%">
                                <option value="" disabled {{ old('guard_name') ? '' : 'selected' }}>Pilih Guard</option>
                                <option value="web" {{ old('guard_name') == 'web' ? 'selected' : '' }}>web</option>
                                <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>api</option>
                            </select>
                        </div>
                    
                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> --}}
        @include('sweetalert::alert')
        
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Manage Roles</h4>
                    <p class="sub-header">
                        Easily extend form controls by adding text, buttons, or button groups on either side
                        of textual inputs, custom selects, and custom file inputs
                    </p>

                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form method="GET" action="{{ route('roles.index') }}"
                                class="d-flex flex-wrap align-items-center">
                                <label for="inputPassword2" class="visually-hidden">Search</label>
                                <div class="me-3">
                                    <input type="search" name="search" class="form-control my-1 my-lg-0" id="search"
                                        placeholder="Search roles..." value="{{ request('search') }}">
                                </div>
                                <label for="status-select" class="me-2">Show</label>
                                <div class="me-sm-3">
                                    <select class="form-select my-1 my-lg-0" name="per_page" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <button type="button" class="btn btn-success waves-effect waves-light mb-2 me-1"><i
                                        class="mdi mdi-cog"></i></button>
                                <a href="{{ route('roles.create') }}"
                                    class="btn btn-danger waves-effect waves-light mb-2">Add Role</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <br>
                    {{-- @if(Session::has('success'))
                        <script>
                            toastr.success("{{ Session::get('success') }}");
                        </script>
                    @endif --}}

                    @if (@isset($roles) && $roles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role Name</th>
                                        <th>Guard</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th style="width: 82px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $key => $role)
                                        <tr>
                                            <td style="width: 100px">{{ $roles->firstItem() + $key }}</td>
                                            <td class="table-user">
                                                {{ $role->name }}
                                                {{-- <img src="{{ asset('assets/images/brands/bitbucket.png') }}"
                                                    alt="table-user" class="me-2 rounded-circle">
                                                <a href="" class="text-body fw-semibold">
                                                    
                                                </a> --}}
                                            </td>
                                            <td>
                                                {{ $role->guard_name }}
                                            </td>
                                            <td>
                                                {{ $role->created_at->format('d M, Y') }}
                                            </td>
                                            <td>
                                                {{ $role->updated_at->format('d M, Y') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('roles.edit', $role->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>

                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                    class="delete-role-form" style="display: inline-block;">
                                                    {{-- Atur display agar form tidak memakan lebar penuh jika tidak diinginkan --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-icon btn-delete-role"
                                                        {{-- Terapkan kelas styling Anda di sini --}} data-role-name="{{ $role->name }}"
                                                        {{-- onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')" --}} title="Hapus Role" {{-- Atribut title baik untuk aksesibilitas --}}
                                                        style="background: none; border: none; padding: 0; cursor: pointer; color: inherit;">
                                                        {{-- Contoh styling dasar agar tombol terlihat seperti ikon --}}
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No roles found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {!! $roles->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') !!}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No record found.
                        </div>
                    @endif

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

    <!-- Modal -->
    {{--  <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="addRoleModalLabel">Add Role</h4> <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="formAlert"></div>
                    <form id="roleForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter name" required>
                        </div>
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name</label> <input type="text"
                                class="form-control" id="guard_name" name="guard_name" placeholder="Enter guard (e.g. web)"
                                required>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /.modal -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-role');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const roleName = this.getAttribute('data-role-name');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Role "${roleName}" akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
