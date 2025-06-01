@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Data Akun';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Akun Baru</h4>
                    <p class="text-muted font-14">
                        Form ini untuk menambah data akun.
                    </p>

                    <form action="{{ route('akun.store') }}" method="POST" class="parsley-examples">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="parent_id" class="form-label">Parent Akun (jika ada)<span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="parent_id" name="parent_id" required
                                    data-toggle="select2" data-width="100%"></option>
                                    <option value="">-- Tidak ada (Root) --</option>
                                    @foreach ($data as $akun)
                                        <option value="{{ $akun->id }}">
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
                                    <option value="asset">Asset</option>
                                    <option value="kewajiban">Kewajiban</option>
                                    <option value="modal">Modal</option>
                                    <option value="pendapatan">Pendapatan</option>
                                    <option value="biaya">Biaya</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Level<span class="text-danger">*</span></label>
                                <select class="form-control select2" id="level" name="level" required
                                    data-toggle="select2" data-width="100%"></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Kode Akun<span class="text-danger">*</span></label>
                            <input type="text" id="account_code" name="account_code" value="{{ old('account_code') }}"
                                parsley-trigger="change" required placeholder="kode akun" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Akun<span class="text-danger">*</span></label>
                            <input type="text" id="account_name" name="account_name" value="{{ old('account_name') }}"
                                parsley-trigger="change" required placeholder="nama akun" class="form-control" />
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
@endsection
