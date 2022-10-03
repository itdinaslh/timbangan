$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // loadTable();
});

// function loadContent() {
//     loadTable();
// }

// $(document).on('shown.bs.modal', function () {
//     PopulateCity();
// });

// function PopulateCity() {
//     $("#idbidang").select2({
//         placeholder: "Pilih Bidang / Unit / Sudin",
//         allowClear: true,
//         ajax: {
//             url: "/search/bidang",
//             dataType: 'json',
//             contentType: "application/json; charset=utf-8",
//             data: function(params) {
//                 return {
//                     q: params.term // search term
//                 };
//             },
//             processResults: function (data) {
//                 return {
//                     results: $.map(data, function (item) {
//                         return {
//                             text: item.NamaBidang,
//                             id: item.id
//                         }
//                     })
//                 }
//             },
//             cache: true
//         },
//     });
// }

// function loadTable() {
//     $('#example').DataTable().clear().destroy();
//     $('#example').DataTable({
//         responsive: true,
//         // Pagination settings
//         // dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
//         // <'row'<'col-sm-12'tr>>
//         // <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

//         // buttons: [
//         //     'print',
//         //     'copyHtml5',
//         //     'excelHtml5',
//         //     'csvHtml5',
//         //     'pdfHtml5',
//         // ],
//         language: {
// 			paginate: {
// 			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
// 			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
// 			}
// 		  },
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: '/edit_transaksi/table',
//             method: 'GET',
//         },
//         columns: [
//             {data:'id', name:'id'},
//             {data:'trans_date', name:'trans_date'},
//             {data:'trans_date_after', name:'trans_date_after'},
//             {data:'door_id', name:'door_id'},
//             {data:'truck_id', name:'truck_id'},
//             {data:'weight', name:'weight'},
//             {data:'weight_after', name:'weight_after'},
//             {data: 'action', name: 'action', orderable: false, searchable: false},
//         ],
//     });
// }

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


