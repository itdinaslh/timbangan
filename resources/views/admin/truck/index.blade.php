@extends('layouts.master')

@section('Title', 'Edit Truk')

@push('styles')
<!-- Datatable -->
<link href="/vendor/select2/css/select2.min.css" rel="stylesheet">

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Truk</h4>
                <div class="card-toolbar">
                    <button class="btn btn-success font-weight-bolder showMe" data-href="/data_truk/add">
                            <!--end::Svg Icon-->
                        </span>Tambah Truk
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <livewire:admin.truck searchable="name, email" exportable/>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Datatable -->
<script src="/vendor/select2/js/select2.full.min.js"></script>
<script src="/pages/js/truck.js"></script>
{{-- <script src="/js/modalForm.js"></script> --}}
<script src="/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
@endpush