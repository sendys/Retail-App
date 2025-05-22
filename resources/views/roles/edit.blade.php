@extends('layouts.app')
@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Roles';
    ?>
    @include('layouts.partials.page-title')

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Role Edit</h4>
                    <p class="text-muted font-14">
                        Form ini untuk perubahan role.
                    </p>

                    <form method="POST" action="{{ route('roles.update', $role->id) }}" class="parsley-examples">
                        @method('PUT')
                        @csrf
                    
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Role<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" parsley-trigger="change" required
                                placeholder="Nama role baru" class="form-control" />
                        </div>
                    
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="guard_name" name="guard_name" required data-toggle="select2" data-width="100%">
                                <option value="" disabled {{ old('guard_name', $role->guard_name) ? '' : 'selected' }}>Pilih Guard</option>
                                <option value="web" {{ old('guard_name', $role->guard_name) == 'web' ? 'selected' : '' }}>web</option>
                                <option value="api" {{ old('guard_name', $role->guard_name) == 'api' ? 'selected' : '' }}>api</option>
                            </select>
                        </div>
                    
                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary waves-effect">Batal</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

    </div>
   
@endsection
