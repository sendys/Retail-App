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
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="phone" min="0"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Perusahaan / Usaha</label>
                            <input class="form-control @error('company_name') is-invalid @enderror" type="text"
                                id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                                placeholder="Enter your company name" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <small class="form-text text-muted">
                                Kata sandi harus mengandung setidaknya satu huruf kecil, satu huruf besar,
                                satu angka dan satu karakter khusus (@$!%*?&)
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-control select2-multiple" data-toggle="select2"
                                data-width="100%" multiple="multiple" data-placeholder="Pilih role...">
                                @foreach ($roles as $roleValue => $roleName)
                                    @if (!auth()->user()->hasRole('admin'))
                                        @if ($roleName !== 'admin')
                                            <option value="{{ $roleValue }}"
                                                {{ in_array($roleValue, $userRole) ? 'selected' : '' }}>
                                                {{ $roleName }}
                                            </option>
                                        @endif
                                    @else
                                        <option value="{{ $roleValue }}"
                                            {{ in_array($roleValue, $userRole) ? 'selected' : '' }}>
                                            {{ $roleName }}
                                        </option>
                                    @endif
                                @endforeach

                                {{--   @foreach ($roles as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}"
                                        {{ in_array($roleValue, $userRole) ? 'selected' : '' }}>
                                        {{ $roleName }}
                                    </option>
                                @endforeach --}}
                            </select>
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
@endsection
