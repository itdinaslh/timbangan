@extends('layouts.master')

@section('Title', 'Edit Permission')

@push('styles')
<!-- Datatable -->
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Permission</h4>
                <div class="card-toolbar">
                    <button class="btn btn-success font-weight-bolder showMe" data-href="/permission/add">
                            <!--end::Svg Icon-->
                        </span>Tambah Permission
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <livewire:admin.permision searchable="name, email" exportable/>                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Datatable -->
<script src="/pages/js/ekspendetur.js"></script>
<script src="/js/sweetalert2@11.js"></script>
@endpush