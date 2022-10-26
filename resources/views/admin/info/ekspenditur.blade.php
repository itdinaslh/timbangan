@extends('layouts.master')

@section('Title', 'Info Ekspenditur')

@push('styles')
<!-- Datatable -->
{{-- <link href="/vendor/select2/css/select2.min.css" rel="stylesheet"> --}}

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Info Ekspenditur</h4>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <livewire:admin.info-ekspenditur searchable="name, email" exportable/>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Datatable -->
{{-- <script src="/vendor/select2/js/select2.full.min.js"></script> --}}
{{-- <script src="/pages/js/truck.js"></script> --}}
{{-- <script src="/js/modalForm.js"></script> --}}
<script src="/js/sweetalert2@11.js"></script>
@endpush