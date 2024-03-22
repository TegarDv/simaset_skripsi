@extends('layouts')
@section('title', 'SIMASET - Pengadaan')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/DataTables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}" />
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

                        <button class="btn btn-primary">Tambah</button>
        
                        <div class="table-responsive">
                            <table class="table table-bordered text-light" style="min-width: 100%;" id="data_transaksi">
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
        <div class="modal faaddid="editModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
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
@endsection