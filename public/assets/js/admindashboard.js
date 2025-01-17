$(document).ready(function () {
    // EMAIL MODAL
    var dataTable = $("#myTable").DataTable();

    // Delete button functionality
    $(".delete-button").on("click", function () {
        var selectedRows = dataTable
            .rows({
                selected: true,
            })
            .indexes()
            .toArray();

        if (selectedRows.length > 0) {
            Swal.fire({
                title: "Seçilen Başvuruları Silmek İstediğinize Emin Misiniz?",
                text: "Bu İşlem Geri Alınamaz.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Evet, sil!",
                cancelButtonText: "Hayır, iptal!",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var formIds = selectedRows.map(function (rowIndex) {
                        return dataTable.row(rowIndex).data().ID;
                    });
                    // Set the action of the form and submit it
                    $.ajax({
                        url: "api/delete-form/" + formIds,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (response) {
                            Swal.fire({
                                title: response.success,
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonText:
                                    "Silinen başvuruları geri Al",
                                cancelButtonText: "Evet Sil.",
                                cancelButtonColor: "#d33",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // User clicked "Undo", so restore the forms
                                    $.ajax({
                                        url:
                                            "api/restore-form/" +
                                            response.formIds,
                                        type: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content"),
                                        },
                                        success: function (response) {
                                            Swal.fire({
                                                title: response.success,
                                                icon: "success",
                                            }).then(() => {
                                                location.reload();
                                            });
                                        },
                                        error: function (error) {
                                            console.log(error);
                                            Swal.fire({
                                                title: "Error!",
                                                text: "An error occurred while restoring the forms.",
                                                icon: "error",
                                            });
                                        },
                                    });
                                } else if (result.isDismissed) {
                                    // User clicked "Cancel", so do nothing and let the forms stay deleted
                                    location.reload();
                                }
                            });
                        },
                        error: function (error) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the forms.",
                                icon: "error",
                            });
                        },
                    });
                }
            });
        } else {
            Swal.fire(
                "Hata!",
                "Lütfen silmek için en az bir satır seçin.",
                "error"
            );
        }
    });
});
