@extends('layouts.master')

@section('Title', 'Dashboard')
@section('MainMenu', 'Dashboard')
@section('PageTitle', 'Timbangan Masuk')

@push('styles')
<link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
{{-- <input type="hidden" id="hidetext" value="{{ $getnopol->nopol }}"> --}}
<div class="row">
    <div class="col-xl-12 col-xxl-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcomb-wp">
                                        <div class="breadcomb-ctn">
                                            <h2>Berat Timbangan</h2>
                                            <p>
                                                {{-- <div id="socket" style="font-size:30px;font-weight:bold;">0 KG</div> --}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                                        {{-- @if($setting->setting_value == "manual") --}}
                                    <div class="breadcomb-report">
                                        <button class="btn" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg2">
                                            Timbangan Manual
                                        </button>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="breadcomb-report">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                                            Timbangan Auto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-xxl-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="breadcomb-list">
                                <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 col- text-center">
                                    <div class="breadcomb-wp">
                                        <div class="breadcomb-ctn text-center">
                                            <h1>TRUK SEBELUMNYA</h1>
                                            <div id="prevdata"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="breadcomb-list">
                                <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 col- text-center">
                                    <div class="breadcomb-wp">
                                        <div class="breadcomb-ctn text-center">
                                            <h1>TRUK SEKARANG</h1>
                                            <div id="showdata"><h1 style='font-weight:normal;padding-top:40px;'>Berat : {{ $getnopol->berat }} KG</h1><br><h1 style='font-weight:normal'>No Pintu : {{ $getnopol->nopintu }}</h1><br><h1 style='font-weight:normal'> No Lambung : {{ $getnopol->nopol }}</h1><br></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-xl-12 col-xxl-12">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Operator Masuk 
                            <span style="font-size:12px;"></span>
                        </h2>
                        <div class="data-table-list">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Hadir</th>
                                        <th>Tidak Hadir</th>
                                    </thead>
                                    <form method="POST" action="{{ route('absensi') }}">
                                        @csrf
                                        <tbody>
                                            @foreach ($group as $key=>$groups)
                                            <tr>
                                            <th>{{ $groups->name }}<input type="text" style="display:none;" name="groupid[]" value="{{ $groups->id }}"></th>
                                            <th><center><input type="checkbox" name="hadir[{{$key}}]" value="hadir" {{ $groups->kehadiran == "hadir" ? 'checked' : '' }}></center></th>
                                            <th><center><input type="checkbox" name="hadir[{{$key}}]" value="tidak hadir" {{ $groups->kehadiran == "tidak hadir" ? 'checked' : '' }}></center></th>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3"><center><button type="submit" class="btn btn-default">Simpan</button></center></td>
                                            </tr>
                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Daftar Transaksi kelaur</h2>
                        <div class="data-table-list">
                            <div class="table-responsive">
                                <livewire:admin.timbangankeluar.table-trans>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting Timbangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form method="POST" autocomplete="off" action="{{ route('storetk') }}">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="nk-int-mk">
                                        <h2>CCTV</h2>
                                    </div>
                                {{-- <img src="http://192.168.1.190/cgi-bin/api.cgi?cmd=Snap&channel=0&rs=wuuPhkmUCeI9WG7C&user=admin&password=admin123" id="cctvmasuk" style="padding:20px 20px;"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="nk-int-mk">
                                            <h2>RFID</h2>
                                    </div>
                                    <div class="form-group ic-cmp-int">
                                        <div class="nk-int-st">
                                            <input type="text" name="rfid" id="rfidauto" class="form-control" autofocus>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                    <div class='nk-int-mk'>
                                        <h2>Berat</h2>
                                    </div>
                                    <div class='form-group ic-cmp-int'>
                                        <div class='nk-int-st'>
                                            <input tabindex="-1" type='text' name='beratmasuk' class='form-control' value="0" id="beratauto" style=" display:block" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form method="POST" autocomplete="off" action="{{ route('storetk') }}">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="nk-int-mk">
                                        <h2>Nomer Pintu <small>(autocomplete)</small></h2>
                                    </div>
                                    <div class="form-group ic-cmp-int">
                                        <div class="nk-int-st">
                                            <input type="text" name="door_id" class="form-control" id="autocomplete" data-provide="typeahead" autofocus>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row' id="show" style="display:block;">
                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                    <div class='nk-int-mk'>
                                        <h2>Berat</h2>
                                    </div>
                                    <div class='form-group ic-cmp-int'>
                                        <div class='nk-int-st'>
                                            <input type='text' name='beratmasuk' class='form-control' value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Dashboard 1 -->
{{-- <script src="/js/dashboard/dashboard-1.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script>
    $('#printterakhir').click(function(){
        $(this).attr('disabled',true);
    $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '{{ route('printu') }}',
            datatype: 'html',
            success: function (response) {
                 console.log("success");
                 setTimeout(function(){
                    $('#printterakhir').attr('disabled',false);
                }, 5000);
            }
        });
    });

    $("body").on('keypress','#rfidauto',function(e) {
        var rfid = $('#rfidauto').val();
        var berat = $('#beratauto').val();
        if(e.which == 13) {
            $('#rfidauto').attr('disabled',true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('saveauto2') }}',
                data: {
                    rfid : rfid,
                    berat : berat
                },
                datatype: 'html',
                success: function (response){
                    $('#showme').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>'+response+'</div>');
                    $('#rfidauto').val("");
                    setTimeout(function(){
                        $('#rfidauto').attr('disabled',false);
                        $('#rfidauto').focus();
                    }, 5000);
                    //console.table(response);
                }
            });
        }
    });
    $("input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });

    $.get("{{ route('jsondoorm') }}", function(data){
        $("#autocomplete").typeahead({
            source:data,
            items: 10,
            afterSelect: function getdata() {
                var getdata = $('#autocomplete').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('checkdoor') }}',
                    data: {
                        getdata: getdata,
                    },
                    datatype: 'html',
                    success: function (response) {
                        if(response == "<center style='padding-top:80px;font-size:25px;'><b>Data timbangan awal tidak ada</b></center>"){
                            $('#put').html(response);
                        }else{
                            $('#put').html(response[1]);
                            // $('#berat').val(response[2]);
                        }
                    }
                });
            }
        });
    },'json');

    function take() {
        getberat();
    }

    function getberat() {
        var getdata = $('#autocomplete').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '{{ route('getberat') }}',
            data: {
                getdata: getdata,
            },
            datatype: 'html',
            success: function (response) {
                if(response == "Input Nomor Pintu"){
                $('#message').html(response);
            }else{
                $('#replace').html(response);
                $('#message').html("");
            }
            }
        });
    }

    function showtext() {
        var checkBox = document.getElementById("statusc");
        var show = document.getElementById("show");
        var berat = document.getElementById("berat");
        var beratrata = document.getElementById("rata2");
        if (checkBox.checked == true){
            show.style.display = "block";
            beratrata.style.display = "block";
            berat.style.display = "none";
        } else {
            show.style.display = "none";
            beratrata.style.display = "none";
            berat.style.display = "block";
        }
    }

    // function getsocketout() {
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: "GET",
    //         url: '{{ route('socket', 'keluar') }}',
    //         datatype: 'html',
    //         success: function (response) {
    //             document.getElementById('socket').innerHTML = response + " KG";
    //         }
    //     });
    // }

    function showdisplay(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            type: "GET",
            url: '{{ route('showdisplay', 'keluar') }}',
            datatype: 'html',
            success: function (response){
                if(document.getElementById('hidetext').value != response['nopol']){
                var prev_data = $("#showdata").html();
                $("#prevdata").html(prev_data);
                document.getElementById('showdata').innerHTML = "<h1 style='font-weight:normal;padding-top:40px;'>Berat : "+response['berat']+" KG</h1><br><h1 style='font-weight:normal'>No Pintu : "+response['nopintu']+"</h1><br><h1 style='font-weight:normal'> No Lambung : "+response['nopol']+"</h1><br>";
                document.getElementById('hidetext').value = response['nopol'];
                $("#showdata").fadeTo(10000, 500).slideUp(500, function(){
                    var prev_data = $("#showdata").html();
                    $("#prevdata").html(prev_data);
                    $("#showdata").slideUp(500);
                    
                    });   
                }
            }
        });
    }

    setInterval(showdisplay,  1000);

    // function getsocketin() {
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: "GET",
    //         url: '{{ route('socket', 'keluar') }}',
    //         datatype: 'html',
    //         success: function (response) {
    //             document.getElementById('beratauto').value = response;
    //         }
    //     });
    // }

    // setInterval(getsocketout, 2000);
    // setInterval(getsocketin, 2000);

</script>
@endpush