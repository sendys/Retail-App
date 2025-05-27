@extends('layouts.app')

@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'User';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit User</h4>
                    <p class="text-muted font-14">
                        Form ini untuk perubahan user.
                    </p>

                    <form action="{{ route('user.update', $user->id) }}" method="POST" class="parsley-examples">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                parsley-trigger="change" required placeholder="Nama pengguna" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                parsley-trigger="change" required placeholder="Email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" parsley-trigger="change"
                                placeholder="Kosongkan, jika tidak ingin mengganti password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                                    class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                parsley-trigger="change" placeholder="Ulangin password" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-control select2-multiple" data-toggle="select2"
                                data-width="100%" multiple="multiple" data-placeholder="Pilih role...">
                                @foreach ($roles as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}"
                                        {{ in_array($roleValue, $userRole) ? 'selected' : '' }}>
                                        {{ $roleName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Permissions <span class="text-danger">*</span></label>

                            <div class="row">
                                <div class="col-md-6">
                                    @foreach ($permissions as $group => $groupPermissions)
                                        @if ($loop->index % 2 == 0)
                                            <div class="border p-3 rounded mb-3">
                                                <strong>{{ $group ?? 'Tanpa Grup' }}</strong>

                                                <div class="row mt-2">
                                                    @foreach ($groupPermissions as $permission)
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="permissions[]" id="perm_{{ $permission->id }}"
                                                                    value="{{ $permission->name }}"
                                                                    {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="perm_{{ $permission->id }}">
                                                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    @foreach ($permissions as $group => $groupPermissions)
                                        @if ($loop->index % 2 == 1)
                                            <div class="border p-3 rounded mb-3">
                                                <strong>{{ $group ?? 'Tanpa Grup' }}</strong>

                                                <div class="row mt-2">
                                                    @foreach ($groupPermissions as $permission)
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="permissions[]" id="perm_{{ $permission->id }}"
                                                                    value="{{ $permission->name }}"
                                                                    {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="perm_{{ $permission->id }}">
                                                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>



                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
