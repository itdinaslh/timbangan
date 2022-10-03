@extends('layouts.master')

@section('Title', 'Edit Users')

@push('styles')
<!-- Datatable -->
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Users</h4>
                <div class="card-toolbar">
                    <button class="btn btn-success font-weight-bolder showMe" data-href="/data_user/add">
                            <!--end::Svg Icon-->
                        </span>Tambah User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Datatable -->
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/pages/js/user.js"></script>
{{-- <script src="/js/modalForm.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush