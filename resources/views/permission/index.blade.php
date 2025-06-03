@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Permission';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Manage Permissions</h4>
                    <p class="sub-header">
                        Easily extend form controls by adding text, buttons, or button groups on either side
                        of textual inputs, custom selects, and custom file inputs
                    </p>

                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form method="GET" action="{{ route('permission.index') }}"
                                class="d-flex flex-wrap align-items-center">
                                <label for="inputPassword2" class="visually-hidden">Search</label>
                                <div class="me-3">
                                    <input type="search" name="search" class="form-control my-1 my-lg-0" id="search"
                                        placeholder="Search roles..." value="{{ request('search') }}">
                                </div>
                                <label for="status-select" class="me-2">Show</label>
                                <div class="me-sm-3">
                                    <select class="form-select my-1 my-lg-0" name="per_page" onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>
                                <label for="status-select" class="me-2">entries</label>
                            </form>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <button type="button" class="btn btn-success waves-effect waves-light mb-2 me-1"><i
                                        class="mdi mdi-cog"></i></button>
                                <a href="{{ route('permission.create') }}"
                                    class="btn btn-danger waves-effect waves-light mb-2">Add Permission</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <br>
                    @php
                        $groupedPermissions = $permissions->groupBy('group');
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover table-sm mb-0" id="rolesTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th style="width: 100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($groupedPermissions as $group => $items)
                                    {{-- Baris Group --}}
                                    <tr class="table-secondary">
                                        <td colspan="4"><strong>Grup: {{ $group ?? 'Tanpa Grup' }}</strong></td>
                                    </tr>

                                    @foreach ($items as $index => $permission)
                                        <tr>
                                            <td class="ps-4">{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td>
                                                <a href="{{ route('permission.edit', $permission->id) }}"
                                                    class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                                <form action="{{ route('permission.destroy', $permission->id) }}"
                                                    method="POST" class="delete-role-form" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-icon btn-delete-role"
                                                        data-role-name="{{ $permission->name }}" title="Hapus Role"
                                                        style="background: none; border: none; padding: 0; cursor: pointer; color: inherit;">

                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada permission.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {!! $permissions->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') !!}
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('roleForm');
            const alertBox = document.getElementById('formAlert');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const roleId = formData.get('role_id');
                const isEdit = roleId !== '';
                const url = isEdit ?
                    `/roles/${roleId}` :
                    `{{ route('roles.store') }}`;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                            form.reset();
                            document.getElementById('role_id').value = '';
                            setTimeout(() => {
                                bootstrap.Modal.getInstance(document.getElementById(
                                    'custom-modal')).hide();
                                alertBox.innerHTML = '';
                            }, 1000);
                        } else {
                            alertBox.innerHTML =
                                `<div class="alert alert-danger">${data.message}</div>`;
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan!',
                        });
                    });
            });

            // Edit button handler
            document.querySelectorAll('.edit-role').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('role_id').value = this.dataset.id;
                    document.getElementById('name').value = this.dataset.name;
                    document.getElementById('guard_name').value = this.dataset.guard;
                    document.getElementById('addRoleModalLabel').innerText = "Edit Role";
                    new bootstrap.Modal(document.getElementById('custom-modal')).show();
                });
            });

            // Reset form on modal close
            document.getElementById('custom-modal').addEventListener('hidden.bs.modal', function() {
                form.reset();
                document.getElementById('role_id').value = '';
                document.getElementById('addRoleModalLabel').innerText = "Add Role";
            });
        });
    </script>

    {{-- Fungsi Delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-role');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const roleName = this.getAttribute('data-role-name');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        html: `Role "${roleName}"<br>will be permanently deleted.`,
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
