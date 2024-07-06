@extends('template.app')

@section('title', 'Laporan Data Aset')

@section('content')
<h4 class="text-start">Laporan Data Aset</h4>
<div class="card shadow-lg">
    <h5 class="card-header">Data Aset</h5>
    <div class="card-datatable table-responsive">
        <form class="row g-3 m-2 needs-validation" id="printForm" action="{{ route('asset_print') }}" method="POST" novalidate>
            @csrf
            <label for="">Filter Data</label>
            <div class="col-lg-2">
                <select class="form-select" id="filter1" name="tipe_aset" required>
                    <option value="" disabled selected>Filter Tipe Aset</option>
                    <option value="all">All</option>
                    <option value="fisik">Fisik</option>
                    <option value="digital">Digital</option>
                    <option value="layanan">Layanan</option>
                </select>
                <div class="invalid-feedback">
                    Input harus di isi.
                </div>
            </div>
        
            <div class="col-lg-2">
                <select class="form-select" id="filter2" name="status_aset" required>
                    <option value="" disabled selected>Filter Status</option>
                    <option value="all">All</option>
                    @foreach ($status as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Input harus di isi.
                </div>
            </div>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="tanggal_awal" placeholder="Tanggal Awal" id="tanggal_awal" onfocus="(this.type='date')">
            </div>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="tanggal_akhir" placeholder="Tanggal Akhir" id="tanggal_akhir" onfocus="(this.type='date')">
            </div>
        
            <div class="col-lg-4">
                <button type="reset" class="btn btn-warning me-3"><i class="bi bi-arrow-clockwise me-sm-1"></i><span class="d-none d-sm-inline-block">Clear</span></button>
                <button type="submit" class="btn btn-danger"><i class="bi bi-printer me-sm-1"></i><span class="d-none d-sm-inline-block">Print Data</span></button>
            </div>
        </form>
        <div class="ms-3">
            <button id="reloadDatatable" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-sm-1"></i> <span class="d-none d-sm-inline-block">Reload Data</span>
            </button>
        </div>
        <table class="table table-bordered text-light" style="min-width: 100%;" id="data_assets"></table>
    </div>
</div>

{{-- Loader modal --}}
<div class="loader-modal" id="loader-modal">
    <div class="loader"></div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
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
    function showLoader() {
        $('#loader-modal').css('display', 'flex');
        setTimeout(function() {
            hideLoader();
        }, 1000); // Hide loader after 1 second
    }

    function hideLoader() {
        $('#loader-modal').hide();
    }

    $(document).ready(function () {
        var filter1 = '';
        var filter2 = '';
        var tanggal_awal = '';
        var tanggal_akhir = '';
        var datatables = $('#data_assets').DataTable({
            ajax: {
                url: '{{ route('laporanAssetsJson') }}',
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: 'index', width: '5%', name: 'index', title: 'No' },
                { data: 'column2_table', width: '15%', name: 'column2_table', title: 'Kode Aset' },
                { data: 'column3_table', width: '40%', name: 'column3_table', title: 'Detail Aset' },
                { data: 'column4_table', width: '10%', className: 'text-center', name: 'column4_table', title: 'Status' },
                { data: 'column5_table', width: '30%', className: 'text-center', name: 'column5_table', title: 'Tanggal' },
                { data: 'created_at', name: 'created_at1', title: 'Tanggal', visible: false },
                { data: 'created_at', name: 'created_at2', title: 'Tanggal', visible: false }
            ],
            initComplete: function () {
                $('#filter1').on('change', function () {
                    const filter1 = $(this).val();

                    if (filter1 === "all") {
                        datatables.column(2).search("").draw();
                    } else {
                        datatables.column(2).search(filter1).draw();
                    }
                });

                $('#filter2').on('change', function () {
                    filter2 = $(this).val();

                    if (filter2 === "all") {
                        datatables.column(3).search("").draw();
                    } else {
                        datatables.column(3).search(filter2).draw();
                    }
                });

                $('#tanggal_awal').on('change', function () {
                    const tanggal_awal = $(this).val();
                    const formattedDate = new Date(tanggal_awal).toISOString().split('T')[0]; // Format the date to 'YYYY-MM-DD'

                    $.fn.dataTable.ext.search = [];
                    
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            const tanggal = data[5]; // Use the index of the column5_table column
                            const tanggalDate = new Date(tanggal);

                            if (tanggalDate >= new Date(formattedDate)) {
                                return true;
                            }
                            return false;
                        }
                    );

                    datatables.draw();
                });
                $('#tanggal_akhir').on('change', function () {
                    const tanggal_akhir = $(this).val();
                    const formattedDate = new Date(tanggal_akhir).toISOString().split('T')[0]; // Format the date to 'YYYY-MM-DD'

                    $.fn.dataTable.ext.search = [];

                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            const tanggal = data[6]; // Use the index of the column5_table column
                            const tanggalDate = new Date(tanggal);

                            if (tanggalDate <= new Date(formattedDate)) {
                                return true;
                            }
                            return false;
                        }
                    );

                    datatables.draw();
                });

                // $('#tanggal_awal').on('change', function () {
                //     const filter1 = $(this).val();

                //     if (filter1 === "all") {
                //         datatables.column(2).search("").draw();
                //     } else {
                //         datatables.column(2).search(filter1).draw();
                //     }
                // });
            }
        });

        $('#printForm').submit(function(event) {
            const filter1 = $('#filter1');
            const filter2 = $('#filter2');
            const tanggalAwal = $('#tanggal_awal');
            const printForm = $('#printForm')

            if (filter1.val() === "" || filter1.val() === null) {
                filter1.addClass('is-invalid');
                event.preventDefault();
            } else {
                filter1.removeClass('is-invalid');
                filter1.addClass('is-valid');
                setTimeout(function() {
                    filter1.removeClass('is-valid');
                }, 3000);
            }

            if (filter2.val() === "" || filter2.val() === null) {
                filter2.addClass('is-invalid');
                event.preventDefault();
            } else {
                filter2.removeClass('is-invalid');
                filter2.addClass('is-valid');
                setTimeout(function() {
                    filter2.removeClass('is-valid');
                }, 3000);
            }

            if (!this.checkValidity()) {
                event.preventDefault();
            }
        });
        $('#printForm').on('reset', function(event) {
            datatables.column(2).search("").draw();
            datatables.column(3).search("").draw();
        });

        // Handle a create button
        $('.create-btn').on('click', function () {
            showLoader(); // Show loader while loading the create form

            $.ajax({
                url: '/laporan-assets/create', // Assuming this is the route for loading the create form
                type: 'GET',
                success: function (response) {
                    $('#createModal .modal-content').html(response); // Load the create form into the modal
                    $('#createModal').modal('show'); // Show the modal
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while loading the create form.');
                }
            });
        });
        $('#createModal').on('hidden.bs.modal', function() {
            datatables.ajax.reload(function() {
            }, false);
        });

        // Reload data
        $('#reloadDatatable').on('click', function() {
            showLoader();
            datatables.ajax.reload(function() {
            }, false);
        });
    });
</script>
@endpush
@push('jsvendor')
    {{-- <script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script> --}}
    <script src="{!! asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') !!}"></script>
    <script src="{!! asset('assets/libvelixs/client-dist/socket.io.js') !!}"></script>
@endpush