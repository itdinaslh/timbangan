@extends('layouts.master')

@section('Title', 'Edit Transaksi')

@push('styles')
<!-- Datatable -->
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Transaksi</h4>
                <div class="card-toolbar">
                    <button class="btn btn-success font-weight-bolder showMe" data-href="/edit_transaksi/add">
                            <!--end::Svg Icon-->
                        </span>Tambah Transaksi
                    </button>
                </div>
            </div>
            <div class="card-body">
                <livewire:admin.struck searchable="name, email" exportable/>  
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Datatable -->
<script src="/pages/js/struck.js"></script>
<script src="/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
@endpush