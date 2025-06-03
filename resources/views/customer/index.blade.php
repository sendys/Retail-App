@extends('layouts.app')

@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Customers';
    ?>
    @include('layouts.partials.page-title')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Manage Customers</h4>
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form method="GET" action="{{ route('customer.index') }}" class="d-flex flex-wrap align-items-center">
                                <input type="search" name="search" class="form-control my-1 my-lg-0" id="search" placeholder="Search..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary ms-2">Search</button>
                            </form>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('customer.create') }}" class="btn btn-danger waves-effect waves-light mb-2">Add Customer</a>
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
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->company_name }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>
                                            <a href="{{ route('customer.edit', $customer) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('customer.destroy', $customer) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection