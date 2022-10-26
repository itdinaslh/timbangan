@extends('layouts.master')

@section('Title', 'Dashboard')
@section('MainMenu', 'Dashboard')
@section('PageTitle', 'Timbangan')

@push('styles')@endpush

@section('content')
    <livewire:admin.index>
    
@endsection

@push('scripts')
<script src="/js/sweetalert2@11.js"></script>
<script>
	
	$('.form-element-list').hover(
		function(){
		    //$(this).animate({'backgroundColor': '#f5f5f5'},400);
		    $(this).css("background-color", "#dff0d8");
		    //style="background-color:#dff0d8"

		},
		function(){
		    //$(this).animate({'backgroundColor': '#000'},400);
		    $(this).css("background-color", "#ffffff");
		}

	); 
        
    var waktus = $("#trans_date").val();
    var waktuse = $("#trans_dates").val();
</script>
@endpush