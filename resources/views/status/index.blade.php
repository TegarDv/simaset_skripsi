@extends('layouts')
@section('title', 'SIMASET - Pengadaan')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/DataTables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}" />
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
@endsection
@section('content')
{{-- Header --}}
<section id="base">
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <p>
                    <h2 class="text-start">Pengadaan</h2>
                    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque.</h5>
                </p>
            </div>
        </div>

        <div class="container rounded p-1">
            <div class="card shadow-lg">
                <h5 class="card-header text-warning-emphasis">Assets</h5>
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-container">
                        <!-- loader -->
                        <div class="loader-modal" id="loader-modal">
                            <div class="loader"></div>
                        </div>

                        <div class="m-3">
                            <button class="btn btn-primary create-btn">Tambah</button>
                            <button id="reloadDatatable" class="btn btn-primary">Reload Data</button>
                        </div>
        
                        <div class="table-responsive">
                            <table class="table table-bordered text-light" style="min-width: 100%;" id="data_assets">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Aset</th>
                                        <th scope="col">Data Aset</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Close Card --}}

        {{-- Add Modal --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal content will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Detail modal container -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal content will be loaded here -->
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/DataTables-1.13.6/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                url: '{{ route('pengadaanJson') }}',
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                ['5', '10', '25', '50', 'All']
            ],
            scrollY: false,
            columns: [
                { data: null, width: '5%', render: function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { 
                    data: 'kode_aset', 
                    width: '10%', 
                    render: function (data, type, row) {
                        return '<div class="text-light">' + data + '</div>';
                    }
                },
                {
                    data: null,
                    width: '10%',
                    render: function (data, type, row) {
                        var nama_aset = row.nama_aset || '';
                        var tipe_aset = row.tipe_aset || '';
                        var jumlah = row.jumlah || '';
                        var harga = row.harga || '';
                        var masa_berlaku = row.masa_berlaku || '';

                        var nama_asetReturn = '<div class="text-light">Nama: ' + nama_aset + '</div>';
                        var tipe_asetReturn = '<div class="text-light">Tipe: ' + tipe_aset + '</div>';
                        var jumlahReturn = '<div class="text-light">Jumlah: ' + jumlah + '</div>';
                        var hargaReturn = '<div class="text-light">Harga: ' + harga + '</div>';
                        var masa_berlakuReturn = '<div class="text-light">Masa berlaku: ' + masa_berlaku + '</div>';
                        
                        var viewReturn = nama_asetReturn + tipe_asetReturn + jumlahReturn + hargaReturn + masa_berlakuReturn;

                        return viewReturn;
                    }
                },
                { 
                    data: null,
                    width: '10%',
                    render: function (data, type, row) {
                        var masa_berlaku = row.masa_berlaku ? formatDate(row.masa_berlaku) : '';
                        var created_at = row.created_at ? formatDate(row.created_at) : '';
                        var updated_at = row.updated_at ? formatDate(row.updated_at) : '';

                        var masa_berlakuReturn = '<div class="text-light">Masa berlaku: ' + masa_berlaku + '</div>';
                        var created_atReturn = '<div class="text-light">Aset dibuat pada: ' + created_at + '</div>';
                        var updated_atReturn = '<div class="text-light">Terakhir di update pada: ' + updated_at + '</div>';
                        
                        var viewReturn = masa_berlakuReturn + created_atReturn + updated_atReturn;

                        return viewReturn;
                    }
                },
                { 
                    data: 'status',
                    width: '10%',
                    className: 'text-center',
                    render: function (data, type, row) {
                        var badgeClass;
                        if (data === '1') {
                            badgeClass = 'text-bg-success';
                        } else if (data === '2') {
                            badgeClass = 'text-bg-info';
                        } else if (data === '3') {
                            badgeClass = 'text-bg-warning';
                        } else if (data === '4') {
                            badgeClass = 'text-bg-danger';
                        } else {
                            badgeClass = 'text-bg-secondary';
                        }

                        return '<span class="badge rounded-pill ' + badgeClass + '">Status ' + data + '</span>';
                    }
                },
                {
                    data: null,
                    width: '10%',
                    render: function (data, type, row) {
                        var id_aset = row.id || '';

                        var id_asetReturn = '<div class="text-light">ID: ' + id_aset + '</div>';

                        var editButton = '<button class="btn btn-sm btn-outline-secondary m-1 edit-app-btn" data-app-id="' + id_aset + '" title="Edit"><i class="bi bi-pencil-square text-light"></i></button>';
                        var showButton = '<button class="btn btn-sm btn-outline-secondary btn-action m-1 view-app-btn" data-app-id="' + id_aset + '" title="View"><i class="bi bi-eye text-light"></i></button>';
                        var deleteButton = '<button class="btn btn-sm btn-outline-secondary btn-action m-1 delete-app-btn" data-app-id="' + id_aset + '" title="Delete"><i class="bi bi-trash3 text-light"></i></button>';
                        
                        var viewReturn = editButton + showButton + deleteButton;

                        return viewReturn;
                    }
                }
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
                url: '/pengadaan/create', // Assuming this is the route for loading the create form
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
                url: '/pengadaan/' + appId,
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
                url: '/pengadaan/' + appId + '/edit',
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
                        url: '/pengadaan/' + appId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (response) {
                            showToast(response.message, 'success');
                        },
                        error: function (xhr, status, error) {
                            showToast('An error occurred while deleting the asset.', 'error');
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
@endsection