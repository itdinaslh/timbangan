@extends('layouts.master')

@section('Title', 'Dashboard')
@section('MainMenu', 'Dashboard')
@section('PageTitle', 'Timbangan')

@push('styles')
{{-- <link rel="stylesheet" href="{{ asset('/css/datagrid/datatables/datatables.bundle.css') }}" /> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css" integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA==" crossorigin="anonymous" /> --}}
@endpush

@section('content')
    <livewire:admin.index>
    
@endsection

@push('scripts')
<!-- Dashboard 1 -->
{{-- <script src="/js/dashboard/dashboard-1.js"></script> --}}
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
        

    function caridata()
    {
        var waktu = $('#tanggal').val();
        var penugasan = $('#penugasan').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '{{ route('getrittonase') }}',
            data: {
                waktu : waktu,
                penugasan : penugasan,
            },
            datatype: 'html',
            success: function (response){
                    $('#tonaserit').html(response)
            }
        });

    }

    // setInterval(function(){
    //     var waktu = $("#trans_date").val();
    //     var waktu2 = $("#trans_dates").val();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: "POST",
    //         url: '{{ route('getritases') }}',
    //         data: {
    //             waktu: waktu,
    //         },
    //         datatype: 'html',
    //         success: function (response){
    //             var html_data = response.split("|");
    //             $("#keluar").html(html_data[0]);
    //         }
    //     });

    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: "POST",
    //         url: '{{ route('gettonases') }}',
    //         data: {
    //             waktu: waktu2,
    //         },
    //         datatype: 'html',
    //         success: function (response){
    //             var html_data = response.split("|");
    //             $("#tonase").html(html_data[0]);
    //         }
    //     });
    // }, 10000);
    var waktus = $("#trans_date").val();
    var waktuse = $("#trans_dates").val();

    $.post( "{{ route('jz') }}", {user: "adminscan", date:""}).done(function(data) {
    $('#showrit').html(data);
    });

    $.post( "{{ route('getritases') }}", {wakut:waktus}).done(function(data) {
        $('#keluar').html(data);
    });

    $.post( "{{ route('gettonases') }}", {waktu:waktuse}).done(function(data) {
        $('#tonase').html(data);
    });
</script>
@endpush