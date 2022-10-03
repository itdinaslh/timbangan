function bindForm(dialog) {
    $("form", dialog).submit(function () {
        $.ajax({
            url: this.action,
            type: this.method,
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    $("#myModal").modal("hide");
                    showSuccessMessage();
                } else if (result.invalid) {
                    showInvalidMessage();
                } else {
                    $("#myModalContent").html(result);
                    bindForm();
                }
            },
        });
        return false;
    });
}

function showSuccessMessage() {
    Swal.fire({
        position: "top-end",
        type: "success",
        title: "Data berhasil disimpan!",
        showConfirmButton: false,
        timer: 1000,
    }).then(function () {
        loadContent();
    });
}

function showDeleteMessage() {
    Swal.fire({
        position: "top-end",
        type: "success",
        title: "Data berhasil dihapus!",
        showConfirmButton: false,
        timer: 1000,
    }).then(function () {
        loadContent();
    });
}


function showInvalidMessage() {
    Swal.fire({
        position: "top-end",
        type: "Danger",
        title: "Sudah ada bulan & tahun yang sama!!",
        showConfirmButton: false,
        timer: 1000,
    }).then(function () {
        loadContent();
    });
}

$(document).on("shown.bs.modal", function () {
    $(this).find("[autofocus]").focus();
});

$(document).on("click", ".showMe", function () {
    $("#myModalContent").load($(this).attr("data-href"), function () {
        $("#myModal").modal('show');

        bindForm(this);
    });

    return false;
});
