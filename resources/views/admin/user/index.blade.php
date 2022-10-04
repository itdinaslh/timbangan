@extends('layouts.master')

@section('Title', 'Edit Users')

@push('styles')
<!-- Datatable -->
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Users</h4>
                <div class="card-toolbar">
                    <a class="btn btn-success font-weight-bolder" href="{{ route('users.create') }}">
                            <!--end::Svg Icon-->
                        </span>Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <livewire:admin.user searchable="name, email" exportable/>                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Datatable -->
<script src="/pages/js/user.js"></script>
{{-- <script src="/js/modalForm.js"></script> --}}
<script src="/js/sweetalert2@11.js"></script>
@endpush