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

// function loadTable() {
//     $('#example').DataTable().clear().destroy();
//     $('#example').DataTable({
//         responsive: true,
//         language: {
// 			paginate: {
// 			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
// 			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
// 			}
// 		  },
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: '/data_ekspenditur/table',
//             method: 'GET',
//         },
//         columns: [
//             {data:'id', name:'id'},
//             {data:'ekspenditur_name', name:'ekspenditur_name'},
//             {data:'status', name:'status'},
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
            url: '/data_ekspenditur/delete/'+product_id,
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


