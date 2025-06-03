@extends('layouts.app')

@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Suppliers';
    ?>
    @include('layouts.partials.page-title')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Manage Suppliers</h4>
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form method="GET" action="{{ route('supplier.index') }}" class="d-flex flex-wrap align-items-center">
                                <input type="search" name="search" class="form-control my-1 my-lg-0" id="search" placeholder="Search..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary ms-2">Search</button>
                            </form>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('supplier.create') }}" class="btn btn-danger waves-effect waves-light mb-2">Add Supplier</a>
                        </div>
                    </div>
                    <br>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-centered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->company_name }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>
                                            <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection