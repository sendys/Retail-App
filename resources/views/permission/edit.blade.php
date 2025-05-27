@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Permission</h4>

    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Permission</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $permission->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="group" class="form-label">Group Permission</label>
            <input type="text" class="form-control" name="group" id="group" value="{{ old('group', $permission->group) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('permission.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection