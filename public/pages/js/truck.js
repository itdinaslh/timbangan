$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});



$(document).on('shown.bs.modal', function () {
    PopulateCity();
    $('#area').select2();
    $('#penugasan').select2();
});

function PopulateCity() {
    $("#ekspenditur").select2({
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


