@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Roles';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between mb-2">
                            <div class="col-auto">
                                <form>
                                    <div class="mb-2">
                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                        <input type="search" class="form-control" id="inputPassword2"
                                            placeholder="Search...">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-2 me-1"><i
                                            class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light mb-2"
                                        data-bs-toggle="modal" data-bs-target="#custom-modal">Add Role</button>
                                </div>
                            </div><!-- end col-->
                        </div>

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
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td style="width: 100px">{{ $loop->iteration }}</td>
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
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No record found.
                            </div>
                        @endif

                        <ul class="pagination pagination-rounded justify-content-end mb-0 mt-2">
                            <li class="page-item">
                                <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </li>
                        </ul>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="addRoleModalLabel">Add Role</h4> <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Alert box for JavaScript messages --}}
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
    </div>
    <!-- /.modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('roleForm');
            //const alertBox = document.getElementById('formAlert');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch("{{ route('roles.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Success handling
                        if (data.success) {
                            alertBox.innerHTML =
                                `<div class="alert alert-success">${data.message}</div>`;
                            form.reset();
                            // Close modal after short delay
                            setTimeout(() => {
                                const modal = bootstrap.Modal.getInstance(document
                                    .getElementById('custom-modal'));
                                modal.hide();
                                alertBox.innerHTML = '';
                                // Optional: refresh table or data
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        // Error handling
                        error.json().then(err => {
                            let messages = '';
                            for (let key in err.errors) {
                                messages += `<div>${err.errors[key][0]}</div>`;
                            }
                            alertBox.innerHTML =
                                `<div class="alert alert-danger">${messages}</div>`;
                        });
                    });
            });
        });
    </script>

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
