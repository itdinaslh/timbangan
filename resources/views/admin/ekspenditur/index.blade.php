@extends('layouts.master')

@section('Title', 'Edit Ekspendetur')

@push('styles')
<!-- Datatable -->
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Ekspendetur</h4>
                <div class="card-toolbar">
                    <button class="btn btn-success font-weight-bolder showMe" data-href="/data_ekspenditur/add">
                            <!--end::Svg Icon-->
                        </span>Tambah Ekspendetur
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <livewire:admin.ekspenditur searchable="name, email" exportable/>                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Datatable -->
<script src="/pages/js/ekspendetur.js"></script>
<script src="/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
@endpush