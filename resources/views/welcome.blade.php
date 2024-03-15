@extends('layouts')
@section('title', 'SIMASET- Dashboard')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/DataTables/DataTables-1.13.6/css/dataTables.bootstrap5.min.css') }}" />
@endsection
@section('content')
{{-- Header --}}
<section id="base">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Dashboard<br>Dash</h2>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/DataTables-1.13.6/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection