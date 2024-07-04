@extends('template.app')

@section('title', 'Permintaan Aset')

@section('content')
<h4 class="text-start">Asset Permintaan</h4>
<div class="card shadow-lg">
    <h5 class="card-header">Data Permintaan</h5>
    <div class="card-body">
        <div class="alert alert-info d-flex align-items-center" style="color: #000;"  role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-diamond-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <div>
                Berisi list data permintaan aset.
            </div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <div class="ms-3">
            <button class="btn btn-primary create-btn">
                <i class="ti ti-plus me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Permintaan</span>
            </button>
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

<!-- Detail modal container -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

{{-- Accept Modal --}}
<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
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
                url: '{{ route('permintaanJson') }}',
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: 'index', width: '5%', name: 'index', title: 'No' },
                { data: 'column2_aset', width: '10%', name: 'column2_aset', title: 'Tanggal' },
                { data: 'column3_aset', width: '10%', name: 'column3_aset', title: 'Permintaan' },
                { data: 'column4_aset', width: '10%', name: 'column4_aset', title: 'Tipe Aset' },
                { data: 'column5_aset', width: '10%', className: 'text-center', name: 'column5_aset', title: 'Action' },
            ],
            // initComplete: function () {
            //     // Add event listener for the filter change
            //     $('#userFilter').on('change', function () {
            //         userFilter = $(this).val();

            //         // Apply the filter to the "Username" column
            //         datatables.column(1).search(userFilter).draw();
            //     });

            //     $('#statusFilter').on('change', function () {
            //         statusFilter = $(this).val();

            //         // Apply the filter to the "Action" column
            //         datatables.column(6).search(statusFilter).draw();
            //     });
            // }
        });

        // Handle a create button
        $('.create-btn').on('click', function () {
            showLoader(); // Show loader while loading the create form

            $.ajax({
                url: '/asset-permintaan/create', // Assuming this is the route for loading the create form
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

        // Handle view button click event
        $('#data_assets').on('click', '.view-app-btn', function () {
            var appId = $(this).data('app-id');

            showLoader(); // Show loader while loading the view form

            $.ajax({
                url: '/asset-permintaan/' + appId,
                type: 'GET',
                success: function (response) {
                    $('#detailModal .modal-content').html(response);
                    $('#detailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while loading the view form.');
                }
            });
        });

        $('#data_assets').on('click', '.edit-app-btn', function () {
            var appId = $(this).data('app-id');

            showLoader(); // Show loader while loading the view form

            $.ajax({
                url: '/asset-permintaan/' + appId + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#editModal .modal-content').html(response);
                    $('#editModal').modal('show');
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while loading the view form.');
                }
            });
        });
        $('#editModal').on('hidden.bs.modal', function() {
            datatables.ajax.reload(function() {
            }, false);
        });

        $('#data_assets').on('click', '.accept-app-btn', function () {
            var appId = $(this).data('app-id');

            showLoader(); // Show loader while loading the view form

            $.ajax({
                url: '/asset-permintaan/' + appId + '/accept',
                type: 'GET',
                success: function (response) {
                    $('#acceptModal .modal-content').html(response);
                    $('#acceptModal').modal('show');
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while loading the view form.');
                }
            });
        });
        $('#editModal').on('hidden.bs.modal', function() {
            datatables.ajax.reload(function() {
            }, false);
        });

        $('#data_assets').on('click', '.delete-app-btn', function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var appId = $(this).data('app-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/asset-permintaan/' + appId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            showLoader();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'swalBtnConfirm swalButton',
                                }
                            });
                            reloadDatatable();
                            hideLoader();
                        },
                        error: function(error) {
                            // console.log(error.responseJSON.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.responseJSON.message,
                                customClass: {
                                    confirmButton: 'swalBtnConfirm swalButton',
                                }
                            });
                        }
                    });
                }
            });
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