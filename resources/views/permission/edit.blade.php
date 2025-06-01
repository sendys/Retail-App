@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Permissions';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Permission Edit</h4>
                    <p class="text-muted font-14">
                        Form ini untuk perubahan Permission.
                    </p>

                    <form action="{{ route('permission.update', $permission->id) }}" method="POST" class="parsley-examples">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Group Permission<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="group" name="group"
                                value="{{ old('group', $permission->group) }}" parsley-trigger="change" required
                                placeholder="Group Permission" class="form-control" disabled />
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Permission<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $permission->name) }}"
                                parsley-trigger="change" required placeholder="Nama Permission" class="form-control" />
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
                            <a href="{{ route('permission.index') }}" class="btn btn-secondary waves-effect">Batal</a>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
