@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Data Akun';
    ?>

    @include('layouts.partials.page-title')
    @include('layouts.partials.preloader')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Akun Edit</h4>
                    <p class="text-muted font-14">
                        Form ini untuk perubahan data akun.
                    </p>

                    <form action="{{ route('akun.update', $account->id) }}" method="POST" class="parsley-examples">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="parent_id" class="form-label">Parent Akun (jika ada)<span
                                        class="text-danger">*</span></label>
                                <select class="form-select select2" id="parent_id" name="parent_id" required
                                    data-toggle="select2" data-width="100%"></option>
                                    <option value="">-- Tidak ada (Root) --</option>
                                    @foreach ($accounts as $akun)
                                        <option value="{{ $akun->id }}"
                                            {{ $account->parent_id == $akun->id ? 'selected' : '' }}>
                                            {{ str_repeat('--', $akun->level - 1) . ' ' . $akun->account_code . ' - ' . $akun->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="account" class="form-label">Jenis Akun<span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="account_type" name="account_type" required
                                    data-toggle="select2" data-width="100%"></option>
                                    <option value="asset" {{ $account->account_type == 'asset' ? 'selected' : '' }}>Asset
                                    </option>
                                    <option value="kewajiban" {{ $account->account_type == 'kewajiban' ? 'selected' : '' }}>
                                        Kewajiban</option>
                                    <option value="modal" {{ $account->account_type == 'modal' ? 'selected' : '' }}>Modal
                                    </option>
                                    <option value="pendapatan"
                                        {{ $account->account_type == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                                    <option value="biaya" {{ $account->account_type == 'biaya' ? 'selected' : '' }}>Biaya
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Posted<span class="text-danger">*</span></label>
                                <select class="form-control select2" id="is_postable" name="is_postable" required
                                    data-toggle="select2" data-width="100%"></option>
                                    <option value="yes" {{ $account->is_postable == 'yes' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="no" {{ $account->is_postable == 'no' ? 'selected' : '' }}>No
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Kode Akun<span class="text-danger">*</span></label>
                            <input type="text" id="account_code" name="account_code"
                                value="{{ old('account_code', $account->account_code) }}" parsley-trigger="change" required
                                placeholder="kode akun" class="form-control" />
                            @if ($errors->has('account_code'))
                                <div class="text-danger">{{ $errors->first('account_code') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Akun<span class="text-danger">*</span></label>
                            <input type="text" id="account_name" name="account_name"
                                value="{{ old('account_name', $account->account_name) }}" parsley-trigger="change" required
                                placeholder="nama akun" class="form-control" />
                            @if ($errors->has('account_name'))
                                <div class="text-danger">{{ $errors->first('account_name') }}</div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>

                            <a href="{{ route('akun.index') }}" class="btn btn-secondary waves-effect">Kembali</a>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $.toast({
                    heading: 'Success',
                    text: `{!! session('success') !!}`,
                    showHideTransition: 'slide up',
                    icon: 'success',
                    loader: true,
                    loaderBg: '#2ecc71',
                    position: 'top-right',
                    hideAfter: 3000
                });
            });
        </script>
    @endif
@endsection
