@extends('template.app')

@section('title', 'Laporan Transaksi Aset')

@section('content')
<h4 class="text-start">Laporan Transaksi Aset</h4>
<div class="card shadow-lg">
    <h5 class="card-header">Transaksi Aset</h5>
    <div class="card-datatable table-responsive">
        <form class="row g-3 m-2 needs-validation" id="printForm" action="{{ route('transaksi_print') }}" method="POST" novalidate>
            @csrf
            <label for="">Filter Data</label>
            <div class="col-lg-4">
                <select class="form-select" id="filter1" name="tipe_transaksi" required>
                    <option value="">Select Tipe Transaksi</option>
                    <option value="all">All</option>
                    <option value="peminjaman">Peminjaman</option>
                    <option value="pengembalian">pengembalian</option>
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
    var filter1 = '';
    var tanggal_awal = '';
    var tanggal_akhir = '';
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
        var datatables = $('#data_assets').DataTable({
            ajax: {
                url: '{{ route('laporanTrxJson') }}',
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: 'index', width: '5%', name: 'index', title: 'No' },
                { data: 'column2_table', name: 'column2_table', title: 'Waktu' },
                { data: 'column3_table', name: 'column3_table', title: 'Tipe Transaksi' },
                { data: 'column4_table', name: 'column4_table', title: 'Kode Transaksi' },
                { data: 'column5_table', name: 'column5_table', title: 'Kode Aset' },
                { data: 'column6_table', name: 'column6_table', title: 'Stock' },
                { data: 'created_at', name: 'created_at', title: 'Tanggal', visible: false }
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
                function filterByDate() {
                    const tanggal_awal = $('#tanggal_awal').val();
                    const tanggal_akhir = $('#tanggal_akhir').val();
                    const formattedDateAwal = tanggal_awal ? new Date(tanggal_awal).toISOString().split('T')[0] : null;
                    const formattedDateAkhir = tanggal_akhir ? new Date(tanggal_akhir).toISOString().split('T')[0] : null;

                    $.fn.dataTable.ext.search = [];

                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            const tanggal = data[6]; // Use the index of the column5_table column
                            const tanggalDate = new Date(tanggal);

                            if (
                                (formattedDateAwal === null || tanggalDate >= new Date(formattedDateAwal)) &&
                                (formattedDateAkhir === null || tanggalDate <= new Date(formattedDateAkhir))
                            ) {
                                return true;
                            }
                            return false;
                        }
                    );
                    datatables.draw();
                }

                $('#tanggal_awal').on('change', filterByDate);
                $('#tanggal_akhir').on('change', filterByDate);
            }
        });
        $('#printForm').submit(function(event) {
            const filter1 = $('#filter1');

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

            if (!this.checkValidity()) {
                event.preventDefault();
            }
        });
        $('#printForm').on('reset', function(event) {
            datatables.column(2).search("").draw();
            datatables.column(3).search("").draw();
            $.fn.dataTable.ext.search = [];
            datatables.draw();
        });

        // Handle a create button
        $('.create-btn').on('click', function () {
            showLoader(); // Show loader while loading the create form

            $.ajax({
                url: '/laporan-transaksi/create', // Assuming this is the route for loading the create form
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