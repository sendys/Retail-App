@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Roles';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Role Baru</h4>
                    <p class="text-muted font-14">
                        Form ini untuk menambah beberapa role.
                    </p>
                    <form id="roleForm" class="parsley-examples">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Role<span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    parsley-trigger="change" required placeholder="Nama role baru" class="form-control" />

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guard_name" class="form-label">Guard Name<span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="guard_name" name="guard_name" required
                                    data-toggle="select2" data-width="100%">
                                    {{-- <option value="" disabled {{ old('guard_name') ? '' : 'selected' }}>Pilih Guard --}}
                                    </option>
                                    <option value="web" {{ old('guard_name') == 'web' ? 'selected' : '' }}>web
                                    </option>
                                    <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>api
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="permission-dragula" data-plugin="dragula">
                            @foreach ($permissions->chunk(ceil(count($permissions) / 3)) as $permissionChunk)
                                <div class="col-md-4 mb-3">
                                    @foreach ($permissionChunk as $group => $groupPermissions)
                                        <div class="card mb-0 mt-3 border ">
                                            <div class="card-body">
                                                <div class="form-check form-check-success mb-2">
                                                    <input class="form-check-input group-check" type="checkbox"
                                                        id="check_{{ Str::slug($group) }}"
                                                        data-group="{{ Str::slug($group) }}">
                                                    <label class="form-check-label fw-bold"
                                                        for="check_{{ Str::slug($group) }}">
                                                        {{ $group }}
                                                    </label>
                                                </div>

                                                <div class="row mt-2">
                                                    @foreach ($groupPermissions as $permission)
                                                        <div class="col-md-12">
                                                            <div class="form-check mb-2 form-check-primary">
                                                                <input
                                                                    class="form-check-input rounded-circle perm-{{ Str::slug($group) }}"
                                                                    type="checkbox" name="permissions[]"
                                                                    id="perm_{{ $permission->id }}"
                                                                    value="{{ $permission->name }}">
                                                                <label class="form-check-label"
                                                                    for="perm_{{ $permission->id }}">
                                                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>


                        <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary waves-effect">Batal</a>

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

                fetch("{{ route('roles.store') }}", {
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
            $('.select2-multiple').select2({
                allowClear: true
            });

            $(document).on('select2:open', () => {
                let input = document.querySelector('.select2-container--open .select2-search__field');
                if (input) {
                    input.focus();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const groupChecks = document.querySelectorAll('.group-check');

            groupChecks.forEach(groupCheck => {
                const group = groupCheck.dataset.group;
                const checkboxes = document.querySelectorAll('.perm-' + group);

                // Saat "Check All" grup diklik
                groupCheck.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });

                // Saat salah satu checkbox di grup diubah
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        const allChecked = [...checkboxes].every(c => c.checked);
                        groupCheck.checked = allChecked;
                    });
                });

                // Set awal status checkbox grup
                const allChecked = [...checkboxes].every(c => c.checked);
                groupCheck.checked = allChecked;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const containers = Array.from(document.querySelectorAll('#permission-dragula .col-md-4'));
            if (containers.length) {
                dragula(containers);
            }
        });
    </script>
@endsection
