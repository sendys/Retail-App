@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Roles';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Role Edit</h4>
                    <p class="text-muted font-14">
                        Form ini untuk perubahan role.
                    </p>

                    <form id="roleForm" class="parsley-examples">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Role<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}"
                                parsley-trigger="change" required placeholder="Nama role baru" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="guard_name" name="guard_name" required
                                data-toggle="select2" data-width="100%">
                                <option value="" disabled
                                    {{ old('guard_name', $role->guard_name) ? '' : 'selected' }}>Pilih Guard</option>
                                <option value="web"
                                    {{ old('guard_name', $role->guard_name) == 'web' ? 'selected' : '' }}>web</option>
                                <option value="api"
                                    {{ old('guard_name', $role->guard_name) == 'api' ? 'selected' : '' }}>api</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('roleForm');
            const alertBox = document.getElementById('formAlert');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch("{{ route('roles.update', $role->id) }}?_method=PUT", {
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
                                title: 'Berhasil!',
                                html: `Data "${data.message}"<br>berhasil tersimpan.`,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = data.redirect_url;
                            });
                        } else {
                            alertBox.innerHTML =
                                `<div class="alert alert-danger">${data.message}</div>`;
                        }
                    })
                    .catch(error => {
                        alertBox.innerHTML =
                            `<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data.</div>`;
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $(document).on('select2:open', () => {
                let input = document.querySelector('.select2-container--open .select2-search__field');
                if (input) {
                    input.focus();
                }
            });
        });
    </script>
@endsection
