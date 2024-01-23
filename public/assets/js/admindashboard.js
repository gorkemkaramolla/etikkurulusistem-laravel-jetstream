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
                    $("#deleteForm")
                        .attr("action", "/delete-form/" + formIds)
                        .submit();
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
