@extends('layouts.app')

@section('content')
    <?php
    $sub_title = 'Tables';
    $title = 'Manage Data Akun';
    ?>
    @include('layouts.partials.page-title')

    {{--  @dd(Auth::user()->getAllPermissions())  --}}

    {{-- @dd(Auth::user()->can('create users')) --}}

    <style>
        .root-row {
            background-color: #e6f0ff;
            /* biru muda */
            font-weight: 600;
            font-weight: bold;
        }
    </style>

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Manage Data akun</h4>
                    <p class="sub-header">
                        Easily extend form controls by adding text, buttons, or button groups on either side
                        of textual inputs, custom selects, and custom file inputs
                    </p>

                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <form method="GET" action="{{ route('akun.index') }}"
                                class="d-flex flex-wrap align-items-center">
                                <label for="status-select" class="me-2">Show</label>
                                <div class="me-sm-2">
                                    <select class="form-select " name="per_page" onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <label for="inputPassword2" class="visually-hidden">Search</label>
                                <div class="search-bar position-relative mb-sm-0 mb-2">
                                    <input type="search" name="search" class="form-control my-1 my-lg-0" id="search"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <span class="mdi mdi-magnify"></span>
                                </div>

                            </form>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <button type="button" class="btn btn-success waves-effect waves-light mb-2 me-1"><i
                                        class="mdi mdi-cog"></i></button>
                                <a href="{{ route('akun.create') }}"
                                    class="btn btn-danger waves-effect waves-light mb-2">Add Data Akun</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <br>

                    @if (isset($data) && $data->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover table-sm mb-0" id="rolesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 100px;"></th>
                                        <th style="width: 300px;">Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Tipe</th>
                                        <th>Posted</th>
                                        <th style="width: 100px;">Saldo</th>
                                    </tr>
                                </thead>

                                <!-- Satu tbody saja -->
                                <tbody id="data-tbody">
                                    <!-- Spinner loading -->
                                    <tr id="loading-row">
                                        <td colspan="6" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">Sedang memuat data...</p>
                                        </td>
                                    </tr>

                                    <!-- Data akun (disembunyikan dulu dengan class d-none) -->
                                    @foreach ($data as $coa)
                                        @php
                                            $level = substr_count($coa->account_code, '-');
                                            $isRoot = $level === 0;
                                            $hasChildren = \App\Models\ChartOfAccount::where(
                                                'parent_id',
                                                $coa->id,
                                            )->exists();
                                        @endphp
                                        <tr class="data-row d-none" @class(['root-row' => $isRoot])>
                                            <td>
                                                <a href="{{ route('akun.edit', $coa->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>

                                                <form action="{{ route('akun.destroy', $coa->id) }}" method="POST"
                                                    class="delete-role-form" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="action-icon btn-delete-role"
                                                        data-role-name="{{ $coa->account_name }}"
                                                        data-has-children="{{ $hasChildren }}"
                                                        title="{{ $hasChildren ? 'Cannot delete - has root accounts' : 'Delete Account' }}"
                                                        style="background: none; border: none; padding: 0; cursor: {{ $hasChildren ? 'not-allowed' : 'pointer' }}; color: {{ $hasChildren ? '#999' : 'inherit' }};"
                                                        {{ $hasChildren ? 'disabled' : '' }}>
                                                        <i class="mdi mdi-delete"
                                                            style="visibility: {{ $hasChildren ? 'hidden' : 'visible' }}"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="padding-left: {{ $level * 20 }}px; font-weight: {{ is_null($coa->parent_id) ? 'bold' : 'normal' }};">{{ $coa->account_code }}</td>
                                            <td style="padding-left: {{ $level * 20 }}px; font-weight: {{ is_null($coa->parent_id) ? 'bold' : 'normal' }};">{{ $coa->account_name }}</td>
                                            <td style="font-weight: {{ is_null($coa->parent_id) ? 'bold' : 'normal' }};">{{ ucfirst($coa->account_type) }}</td>
                                            <td>
                                                @if ($coa->is_postable == 'yes')
                                                    <i class="mdi mdi-check-circle text-success"></i>
                                                @else
                                                    <i class="mdi mdi-close-circle text-danger"></i>
                                                @endif
                                            </td>
                                            <td class="text-end" style="font-weight: {{ is_null($coa->parent_id) ? 'bold' : 'normal' }};">
                                                {{ number_format($coa->account_balance ?? 0, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {!! $data->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') !!}
                        </div>
                    @else
                        <div class="text-center p-4">
                            <img src="{{ asset('assets/images/empty.png') }}" height="150" alt="No data">
                            <h4 class="text-muted mt-3">No Records Found</h4>
                            <p class="text-muted">We couldn't find any akun perkiraan records. Try adding some new perkiraan.</p>
                            <a href="{{ route('akun.create') }}" class="btn btn-primary mt-2">
                                <i class="mdi mdi-plus me-1"></i> Add New akun
                            </a>
                        </div>
                    @endif


                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

    <!-- Script: Hide spinner, show data rows -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loadingRow = document.getElementById('loading-row');
            const dataRows = document.querySelectorAll('.data-row');

            setTimeout(() => {
                if (loadingRow) loadingRow.remove(); // Remove spinner row
                dataRows.forEach(row => row.classList.remove('d-none')); // Show data
            }, 1000);
        });
    </script>

    {{-- Fungsi Delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-role');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const roleName = this.getAttribute('data-role-name');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        html: `Nama Akun "${roleName}"<br>will be permanently deleted.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

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

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $.toast({
                    heading: 'Gagal',
                    text: `{!! session('error') !!}`,
                    showHideTransition: 'slide up',
                    icon: 'danger',
                    loader: true,
                    loaderBg: '#e74c3c',
                    position: 'top-right',
                    hideAfter: 3000
                });
            });
        </script>
    @endif
@endsection
