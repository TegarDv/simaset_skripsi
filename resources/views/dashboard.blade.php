@extends('template.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat datang {{ Auth::user()->name }}</h5>
                        <p class="mb-4">Selamat datang di <span class="fw-medium">Sistem Manajemen Aset Server</span> JTI Polinema</p>    
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('assets/img/man-with-laptop-dark.png') }}" height="140" alt="User Laptop" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-dark.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <h5 class="card-title text-primary">Jumlah Aset Saat Ini</h5>
                        <h4 class="mb-4">
                            {{ $asset_count }}
                        </h4>
                    </div>
                    <span class="badge bg-label-primary rounded p-2">
                        <i class="bi bi-box-seam"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    $userRole = Auth::user()->role;
@endphp
<div class="row g-4 mb-4">
    <div class="{{ Gate::allows('isUser') ? 'col-lg-12' : 'col-lg-6' }}">
        <div class="card">
            <h5 class="card-header">Aset Terbaru</h5>
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>Kode Aset</th>
                            <th>Data Aset</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $loop_data)
                            <tr>
                                <td>
                                    {{ $loop_data->kode_aset }}
                                </td>
                                <td>
                                    Nama: {{ $loop_data->nama_aset }}<br>Tipe: {{ $loop_data->tipe_aset }}<br>Stok: {{ $loop_data->stok_sekarang }}
                                </td>
                                <td>
                                    Dibuat pada: {{ $loop_data->created_at }}<br> Terakhir diupdate: {{ $loop_data->updated_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @canany(['isSuperAdmin', 'isAdmin'])
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">Permintaan Terbaru</h5>
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Permintaan</th>
                                <th>Tipe Asset</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets_request as $loop_data)
                                <tr>
                                    <td>{{ $loop_data->created_at }}</td>
                                    <td>Aset: {{ $loop_data->nama }}<br>Permintaan: {{ $loop_data->stok_permintaan }}<br>Oleh: {{ $loop_data->dataUser->name }}</td>
                                    <td>{{ $loop_data->tipe_aset }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">Transaksi Terbaru</h5>
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Transaksi</th>
                                <th>Kode Aset</th>
                                <th>Jumlah Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $loop_data)
                                <tr>
                                    <td>{{ $loop_data->tanggal_transaksi }}</td>                                
                                    <td>{{ $loop_data->kode_transaksi }}</td>                                
                                    <td>{{ $loop_data->dataAsset->kode_aset }}</td>                                
                                    <td>{{ $loop_data->stok }}</td>                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endcanany
    @can('isSuperAdmin')
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">Aktivitas Terbaru</h5>
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tindakan</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($log_user as $loop_data)
                                <tr>
                                    <td>{{ $loop_data->created_at }}</td>
                                    <td>{{ $loop_data->action }}</td>
                                    <td>{!! nl2br(e($loop_data->detail)) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection
@push('css')
<style>
    .loader-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 10000;
        display: none;
        justify-content: center;
        align-items: center;
    }
    .loader {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        display: inline-block;
        border-top: 6px solid #FFF;
        border-right: 6px solid transparent;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }
    .loader::after {
        content: '';  
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top: 0;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        border-left: 6px solid #FF3D00;
        border-bottom: 6px solid transparent;
        animation: rotation 0.5s linear infinite reverse;
    }
    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@push('cssvendor')
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
@endpush

@push('js')

@endpush
@push('jsvendor')
    {{-- <script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script> --}}
    <script src="{!! asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') !!}"></script>
    <script src="{!! asset('assets/libvelixs/client-dist/socket.io.js') !!}"></script>
@endpush