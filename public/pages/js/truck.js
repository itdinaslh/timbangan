$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadTable();
});

function loadContent() {
    loadTable();
}

$(document).on('shown.bs.modal', function () {
    PopulateCity();
});

function PopulateCity() {
    $("#ekpenditur").select2({
        placeholder: "Pilih Ekpenditur",
        allowClear: true,
        ajax: {
            url: "/data_ekspenditur/search",
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: function(params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.ekspenditur_name,
                            id: item.id
                        }
                    })
                }
            },
            cache: true
        },
    });
}

function loadTable() {
    $('#example').DataTable().clear().destroy();
    $('#example').DataTable({
        responsive: true,
        language: {
			paginate: {
			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
			}
		  },
        processing: true,
        serverSide: true,
        ajax: {
            url: '/data_truk/table',
            method: 'GET',
        },
        columns: [
            {data:'truck_id', name:'truck_id'},
            {data:'door_id', name:'door_id'},
            {data:'rfid_id', name:'rfid_id'},
            {data:'ekspenditur', name:'ekspenditur'},
            {data:'status', name:'status'},
            {data:'kir', name:'kir'},
            {data:'tipe', name:'tipe'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });
}

$('body').on('click', '.deleteProduct', function (){
    var product_id = $(this).data("id");
    var result = confirm("Are You sure want to delete !");
    if(result){
        $.ajax({
            type: "POST",
            url: '/data_truk/delete/'+product_id,
            success: function (data) {
                showDeleteMessage();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }else{
        return false;
    }
});


