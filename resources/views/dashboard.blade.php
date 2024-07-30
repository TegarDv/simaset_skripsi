@extends('template.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    {{-- Jumlah Aset --}}
    <div class="col-lg-8 order-0">
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
    <div class="col-lg-4 col-sm-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"
                            ><i class="ti ti-box ti-28px"></i
                        ></span>
                    </div>
                    <h4 class="mb-0">{{ $asset_count }}</h4>
                </div>
                <p class="mb-0">Jumlah aset saat ini</p>
            </div>
        </div>
    </div>
    {{-- End Jumlah aset --}}
</div>

@canany(['isSuperAdmin', 'isAdmin'])
<div class="row g-4 mb-4">
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            {{-- Aset normal --}}
            <div class="col-lg-6 col-sm-6 mb-3">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-success"
                                    ><i class="ti ti-box ti-28px"></i
                                ></span>
                            </div>
                            <h4 class="mb-0">{{ $asset_normal_count }}</h4>
                        </div>
                        <p class="mb-1">Jumlah aset normal</p>
                        <p class="mb-0">
                            <small class="text-muted">{{ $asset_normal_count }} aset normal dari total </small>
                            <span class="text-heading fw-small me-2">{{ $asset_count }} Aset</span>
                        </p>
                    </div>
                </div>
            </div>
            {{-- End aset normal --}}
        
            {{-- Aset rusak --}}
            <div class="col-lg-6 col-sm-6 mb-3">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"
                                    ><i class="ti ti-box ti-28px"></i
                                ></span>
                            </div>
                            <h4 class="mb-0">{{ $asset_rusak_count }}</h4>
                        </div>
                        <p class="mb-1">Jumlah aset rusak</p>
                        <p class="mb-0">
                            <small class="text-muted">{{ $asset_rusak_count }} aset normal dari total </small>
                            <span class="text-heading fw-small me-2">{{ $asset_count }} Aset</span>
                        </p>
                    </div>
                </div>
            </div>
            {{-- End aset rusak --}}

            {{-- Kategori aset --}}
            <div class="col-lg-12 col-sm-12">
                <div class="card card-border-shadow-info h-100 pb-5">
                  <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Jumlah Aset Berdasarkan Kategori</h5>
                  </div>
                  <div class="card-body d-flex align-items-end">
                    <div class="w-100">
                      <div class="row gy-3">
                        <div class="col-md-4 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-primary me-4 p-2">
                              <i class="ti ti-router ti-lg"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">{{ $aset_fisik_count }}</h5>
                              <small>Aset Fisik</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-info me-4 p-2"><i class="ti ti-network ti-lg"></i></div>
                            <div class="card-info">
                              <h5 class="mb-0">{{ $aset_layanan_count }}</h5>
                              <small>Aset Layanan</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded bg-label-warning me-4 p-2">
                              <i class="ti ti-wave-square ti-lg"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">{{ $aset_digital_count }}</h5>
                              <small>Aset Digital</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            {{-- End kategori aset --}}
        </div>
    </div>

    {{-- Kondisi dan total harga aset --}}
    <div class="col-xxl-6 col-lg-6 col-sm-12">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h5 class="mb-1">Kondisi & Total Harga Aset</h5>
              <p class="card-subtitle mb-1">Total harga seluruh aset adalah Rp {{ number_format($asset_sum ?? 0, 0, ',', '.') }}</p>
              <p class="card-subtitle"><span class="text-success">Aset Normal</span> - <span class="text-danger">Aset Rusak</span></p>
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              <li class="mb-6 d-flex justify-content-between align-items-center">
                <div class="badge bg-label-primary rounded p-1_5"><i class="ti ti-router ti-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <p class="mb-0 ms-4">
                        <span class="h6">Aset Fisik</span><br>
                        <span>Rp {{ number_format($aset_fisik_sum ?? 0, 0, ',', '.') }}</span>
                    </p>
                  <div class="d-flex">
                    <p class="mb-0 text-success">{{ $asset_fisik_normal_count }}</p>
                    <p class="ms-4 text-danger mb-0">{{ $asset_fisik_rusak_count }}</p>
                  </div>
                </div>
              </li>
              <li class="mb-6 d-flex justify-content-between align-items-center">
                <div class="badge bg-label-info rounded p-1_5"><i class="ti ti-network ti-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <p class="mb-0 ms-4">
                        <span class="h6">Aset Layanan</span><br>
                        <span>Rp {{ number_format($aset_layanan_sum ?? 0, 0, ',', '.') }}</span>
                    </p>
                  <div class="d-flex">
                    <p class="mb-0 text-success">{{ $asset_layanan_normal_count }}</p>
                    <p class="ms-4 text-danger mb-0">{{ $asset_layanan_rusak_count }}</p>
                  </div>
                </div>
              </li>
              <li class="mb-6 d-flex justify-content-between align-items-center">
                <div class="badge bg-label-warning rounded p-1_5"><i class="ti ti-wave-square ti-md"></i></div>
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <p class="mb-0 ms-4">
                        <span class="h6">Aset Digital</span><br>
                        <span>Rp {{ number_format($aset_digital_sum ?? 0, 0, ',', '.') }}</span>
                    </p>
                  <div class="d-flex">
                    <p class="mb-0 text-success">{{ $asset_digital_normal_count }}</p>
                    <p class="ms-4 text-danger mb-0">{{ $asset_digital_rusak_count }}</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
    </div>
    {{-- End kondisi dan total harga aset --}}
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <div class="card-title m-0">
        <h5 class="mb-1">Analisa Bisnis</h5>
        <p class="card-subtitle">Analisa Bisnis dan Maintenance Aset</p>
      </div>
    </div>
    <div class="card-body">
      <ul class="nav nav-tabs widget-nav-tabs pb-8 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-1-id"
            aria-controls="navs-1-id"
            aria-selected="true">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-chart-line ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Deviasi Aset</h6>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-2-id"
            aria-controls="navs-2-id"
            aria-selected="false">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-settings-cog ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Biaya<br>Maintenace</h6>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-3-id"
            aria-controls="navs-3-id"
            aria-selected="false">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-maximize-off ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Kadaluarsa</h6>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-4-id"
            aria-controls="navs-4-id"
            aria-selected="false">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-git-pull-request ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Permintaan<br>Pengadaan</h6>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-5-id"
            aria-controls="navs-5-id"
            aria-selected="false">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-user-question ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Permintaan<br>Peminjaman</h6>
          </a>
        </li>
        @can('isSuperAdmin')
        <li class="nav-item">
          <a
            href="javascript:void(0);"
            class="nav-link btn d-flex flex-column align-items-center justify-content-center"
            role="tab"
            data-bs-toggle="tab"
            data-bs-target="#navs-6-id"
            aria-controls="navs-6-id"
            aria-selected="false">
            <div class="badge bg-label-secondary rounded p-2">
              <i class="ti ti-list-details ti-md"></i>
            </div>
            <h6 class="tab-widget-title mb-0 mt-2">Log User</h6>
          </a>
        </li>
        @endcan
      </ul>
      <div class="tab-content p-0 ms-0 ms-sm-2">
        <div class="tab-pane fade show active" id="navs-1-id" role="tabpanel">
          <div class="table-responsive">
            <h5>Deviasi Aset</h5>
            <table class="table table-bordered" id="datatable1"></table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-2-id" role="tabpanel">
          <div class="table-responsive">
            <h5>Biaya Maintenance Aset yang sedang rusak</h5>
            <table class="table table-bordered" id="datatable2">
              <thead>
                <th>Data Aset</th>
                <th>Kode Aset</th>
                <th>Kondisi Aset</th>
                <th>Biaya Maintance</th>
              </thead>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-3-id" role="tabpanel">
          <div class="table-responsive">
            <h5>Aset dengan masa berlaku yang sudah habis</h5>
            <table class="table table-bordered" id="datatable3">
              <thead>
                <th>No</th>
                <th>Data Aset</th>
                <th>Kode Aset</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
              </thead>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-4-id" role="tabpanel">
          <div>
            <h5>5 Permintaan Pengadaan Terbaru</h5>
            <div class="table-responsive pt-0">
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
        <div class="tab-pane fade" id="navs-5-id" role="tabpanel">
          <div>
            <h5>5 Permintaan Peminjaman Terbaru</h5>
            <div class="table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kode Aset</th>
                            <th>Status Permintaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman_aset_request as $loop_data)
                            <tr>
                                <td>
                                    {{ $loop_data->tanggal_permintaan }} <br>
                                    Oleh: {{ $loop_data->dataUser->name }}
                                </td>
                                <td>
                                    {{ $loop_data->dataAsset->kode_aset }}
                                </td>
                                <td>
                                    @if ($loop_data->status_permintaan == 'pending')
                                        <span class="badge border text-bg-warning">{{ $loop_data->status_permintaan }}</span>
                                    @elseif ($loop_data->status_permintaan == 'disetujui')
                                        <span class="badge border text-bg-success">{{ $loop_data->status_permintaan }}</span>
                                    @elseif ($loop_data->status_permintaan == 'ditolak')
                                        <span class="badge border text-bg-danger">{{ $loop_data->status_permintaan }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        @can('isSuperAdmin')
        <div class="tab-pane fade" id="navs-6-id" role="tabpanel">
          <div>
                <h5>5 Aktivitas Terbaru User</h5>
                <div class="table-responsive pt-0">
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
    </div>
</div>
@endcanany

<div class="row g-4 mb-4">
    <div class="col-lg-12">
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
<script>
    $(document).ready(function () {
        var datatables1 = $('#datatable1').DataTable({
            ajax: {
                url: "{{ route('dashboard.index') }}",
                type: 'GET',
                data: function (d) {
                    d.action = 'get_deviasi';
                }
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { 
                    data: null, width: '5%', title: 'No', render: function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'column2', name: 'column2', title: 'Data Aset' },
                { data: 'column3', name: 'column3', title: 'Kode Aset' },
                { data: 'column4', name: 'column4', title: 'Deviasi' },
            ]
        });
        var datatables2 = $('#datatable2').DataTable({
            ajax: {
              url: "{{ route('dashboard.index') }}",
                type: 'GET',
                data: function (d) {
                    d.action = 'get_maintenance';
                }
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: 'column2', name: 'column2', title: 'Data Aset' },
                { data: 'column3', name: 'column3', title: 'Kode Aset' },
                { data: 'column4', name: 'column4', title: 'Kondisi Aset' },
                { data: 'column5', name: 'column5', title: 'Biaya Maintenance' },
            ]
        });
        var datatables3 = $('#datatable3').DataTable({
            ajax: {
                url: "{{ route('dashboard.index') }}",
                type: 'GET',
                data: function (d) {
                    d.action = 'get_kadaluarsa';
                }
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { 
                    data: null, width: '5%', title: 'No', render: function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'column2', name: 'column2', title: 'Data Aset' },
                { data: 'column3', name: 'column3', title: 'Kode Aset' },
                { data: 'column4', name: 'column4', title: 'Tanggal' },
                { data: 'column5', name: 'column5', title: 'Keterangan' },
            ]
        });
    });
</script>
@endpush
@push('jsvendor')
    {{-- <script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script> --}}
    <script src="{!! asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') !!}"></script>
@endpush