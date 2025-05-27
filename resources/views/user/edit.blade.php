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
                                class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                                    class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                parsley-trigger="change" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-control select2-multiple" data-toggle="select2"
                                data-width="100%" multiple="multiple" data-placeholder="Pilih role...">
                                @forelse ($roles as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}"
                                        {{ in_array($roleValue, $userRole) ? 'selected' : '' }}>
                                        {{ $roleName }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Roles:</label><br>
                            @forelse ($roles as $roleValue => $roleName)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="roles[]"
                                        id="role_{{ $roleValue }}" value="{{ $roleValue }}"
                                        {{ in_array($roleValue, $userRole) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="role_{{ $roleValue }}">{{ $roleName }}</label>
                                </div>
                            @empty
                                <p>Tidak ada role tersedia.</p>
                            @endforelse
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
