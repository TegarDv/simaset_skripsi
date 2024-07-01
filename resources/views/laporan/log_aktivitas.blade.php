@extends('template.app')

@section('title', 'Laporan - Log')

@section('content')
<h4 class="text-start">Laporan Log Aktivitas</h4>
<div class="card shadow-lg">
    <h5 class="card-header">Data Aktivitas User</h5>
    <div class="card-datatable table-responsive">
        <div class="ms-3">
            <button id="reloadDatatable" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-sm-1"></i> <span class="d-none d-sm-inline-block">Reload Data</span>
            </button>
            <button class="btn btn-danger create-btn">
                <i class="bi bi-printer me-sm-1"></i><span class="d-none d-sm-inline-block">Print Data</span>
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
        var datatables = $('#data_assets').DataTable({
            ajax: {
                url: '{{ route('laporanActivityJson') }}',
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: 'index', width: '5%', name: 'index', title: 'No' },
                { data: 'column2_table', width: '15%', name: 'column2_table', title: 'Tanggal' },
                { data: 'column3_table', width: '15%', name: 'column3_table', title: 'Tindakan' },
                { data: 'column4_table', width: '65%', className: 'text-center', name: 'column4_aset', title: 'Detail' }
            ],
        });

        // Handle a create button
        $('.create-btn').on('click', function () {
            showLoader(); // Show loader while loading the create form

            $.ajax({
                url: '/laporan-activity/create', // Assuming this is the route for loading the create form
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
            reloadDatatable();
        });

        function formatDate(timestamp) {
            var months = [
                "January", "February", "March", "April", "May", "June", "July",
                "August", "September", "October", "November", "December"
            ];

            var date = new Date(timestamp);
            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            return day + ' ' + months[monthIndex] + ' ' + year;
        }

        function reloadDatatable() {
            datatables.ajax.reload(function() {
            }, false);
        }
    });
</script>
@endpush
@push('jsvendor')
    {{-- <script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script> --}}
    <script src="{!! asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') !!}"></script>
    <script src="{!! asset('assets/libvelixs/client-dist/socket.io.js') !!}"></script>
@endpush