$(document).ready(function () {
    var table = $("#myTable").DataTable({
        responsive: true,
        pageLength: 5,
        lengthChange: false,
        info: false,
        dom: "lfrtip",
        ordering: false,
    });

    // Filter the table based on the selected role when the page loads
    var selectedRole = $("#filterUserRole").val();
    filterTable(selectedRole);

    $("#filterUserRole").change(function () {
        var selectedRole = $(this).val();
        filterTable(selectedRole);
        localStorage.setItem("preSelectedUserRole", selectedRole);
    });
    $(document).ready(() => {
        var preSelectedUserRole = localStorage.getItem("preSelectedUserRole");
        if (preSelectedUserRole) {
            $("#filterUserRole").val(preSelectedUserRole);
            filterTable(preSelectedUserRole);
        }
    });

    function filterTable(role) {
        $.fn.dataTable.ext.search.pop();
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var isActive = table
                .row(dataIndex)
                .node()
                .getAttribute("data-is_user_active");
            var rowRole = table.row(dataIndex).node().getAttribute("data-role");
            if (role === "inactive") {
                return isActive === "0";
            } else {
                return rowRole === role && isActive === "1";
            }
        });
        table.draw();
    }

    $(document).on("click", "#myTable .edit-button", function () {
        event.preventDefault(); // Prevent the button from causing a page reload
        var data = table.row($(this).parents("tr")).data();

        var userId = data[0];
        // Subtract 1 from the userId to get the correct array index
        var userIndex = userId - 1;

        var userName = users[userIndex].name;
        var userLastName = users[userIndex].lastname;
        var userEmail = users[userIndex].email;
        var userUsername = users[userIndex].username;
        var userRole = users[userIndex].role;

        Swal.fire({
            title: "Kullanıcı Bilgilerini Düzenle",
            html: `
<form id="editUserForm" class="text-start space-y-4 p-4">
<label for="username" class="block text-sm font-medium text-gray-700">Yetki</label>

<select id="role" name="role" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    <option value="student" ${
        userRole === "student" ? "selected" : ""
    }>Öğrenci</option>
    <option value="academic" ${
        userRole === "academic" ? "selected" : ""
    }>Akademisyen</option>
    <option value="sekreterlik" ${
        userRole === "sekreterlik" ? "selected" : ""
    }>Sekreterlik</option>
<option value="etik_kurul" ${
                userRole === "etik_kurul" ? "selected" : ""
            }>Etik Kurul</option>

</select>
<label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
<input type="text" placeholder="Bu alan boş" id="username" name="username" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${
                userUsername ? userUsername : ""
            }">
<label for="name" class="block text-sm font-medium text-gray-700">İsim</label>
<input type="text" id="name" name="name" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userName}">
<label for="name" class="block text-sm font-medium text-gray-700">Soy İsim</label>
<input type="text" id="lastname" name="lastnamename" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userLastName}">
<label for="email" class="block text-sm font-medium text-gray-700">Email</label>
<input type="email" id="email" name="email" class="mt-1 focus:ring-indigo-500 focus:ring-2 transition-colors block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="${userEmail}">
</form>
`,
            confirmButtonText: "Değişiklikleri Kaydet",
            showCloseButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            preConfirm: () => {
                let username = Swal.getPopup().querySelector("#username").value;
                let name = Swal.getPopup().querySelector("#name").value;
                let email = Swal.getPopup().querySelector("#email").value;
                let lastname = Swal.getPopup().querySelector("#lastname").value;
                let role = Swal.getPopup().querySelector("#role").value;

                if (false) {
                    Swal.showValidationMessage(`Please enter all fields.`);
                }
                return {
                    username: username,
                    name: name,
                    email: email,
                    lastname: lastname, // Add a comma here
                    role: role,
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                let username = result.value.username;
                let name = result.value.name;
                let email = result.value.email;
                let lastname = result.value.lastname;
                let role = result.value.role;
                Swal.fire({
                    title: `${userId} ID'li kullanıcıyı güncellemek istediğinize emin misiniz?`,
                    text: "Kullanıcı bilgileri güncellenecek.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Onaylıyorum",
                    cancelButtonText: "İptal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/api/edit-user/" + userId,
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            data: {
                                username: username,
                                name: name,
                                email: email,
                                lastname: lastname,
                                role: role,
                            },
                            success: function (response) {
                                Swal.fire(
                                    "Başarıyla!",
                                    "Kullanıcı bilgileri başarıyla değiştirildi.",
                                    "success"
                                ).then(function () {
                                    location.reload(); // Reload the page to fetch the updated user list
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                let errorMessage = jqXHR.responseJSON;
                                console.log(errorMessage);
                                Swal.fire(
                                    "Hata!",
                                    "Kullanıcı bilgileri güncellenirken bir hata oluştu: " +
                                        errorMessage,
                                    "error"
                                );
                            },
                        });
                    }
                });
            }
        });
    });
});
$("#create-user-form").on("submit", function (event) {
    event.preventDefault();

    $.ajax({
        url: "/api/add-new-user",
        method: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').val(),
        },
        success: function (data) {
            if (data.error) {
                Swal.fire({
                    title: "Hata",
                    text: data.error,
                    icon: "error",
                    confirmButtonText: "Tamam",
                });
            } else {
                Swal.fire({
                    title: "Başarılı",
                    text: data.success,
                    icon: "success",
                    confirmButtonText: "Tamam",
                }).then(function () {
                    location.reload(); // Reload the page to fetch the updated user list
                });
            }
        },
        error: function (error) {
            var errorMessage = "";
            $.each(error.responseJSON.errors, function (key, value) {
                errorMessage += value + "\n";
            });

            Swal.fire({
                title: "Hata",
                text: "Bir Hata Oluştu: " + errorMessage,
                icon: "error",
                confirmButtonText: "Tamam",
            });
        },
    });
});
$(".activate-user-form").on("submit", function (event) {
    event.preventDefault(); // Prevent the form from causing a page reload

    var actionUrl = $(this).attr("action");
    var userId = actionUrl.split("/").pop(); // Extract the user id from the action URL

    Swal.fire({
        title:
            "ID'si " +
            userId +
            " olan kullanıcıyı aktif etmek istediğinize emin misiniz?",
        text: "Bu işlem geri alınamaz.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Aktif et!",
        cancelButtonText: "Hayır, iptal!",
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this);
            $.ajax({
                url: this.action,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                success: function (data) {
                    if (data.error) {
                        Swal.fire({
                            title: "Error",
                            text: data.error,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    } else {
                        Swal.fire({
                            title: "Başarılı",
                            text: data.success,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(function () {
                            location.reload(); // Reload the page to fetch the updated user list
                        });
                    }
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        }
    });
});
$(".inactivate-user-form").on("submit", function (event) {
    event.preventDefault(); // Prevent the form from causing a page reload

    var actionUrl = $(this).attr("action");
    var userId = actionUrl.split("/").pop(); // Extract the user id from the action URL

    Swal.fire({
        title:
            "ID'si " +
            userId +
            " olan kullanıcıyı inaktif etmek istediğinize emin misiniz?",
        text: "Bu işlem geri alınamaz.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "İnaktif et!",
        cancelButtonText: "Hayır, iptal!",
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(this);
            $.ajax({
                url: this.action,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                success: function (data) {
                    if (data.error) {
                        Swal.fire({
                            title: "Error",
                            text: data.error,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    } else {
                        Swal.fire({
                            title: "Başarılı",
                            text: data.success,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(function () {
                            location.reload(); // Reload the page to fetch the updated user list
                        });
                    }
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        }
    });
});

$(".pw-unvisible").click(function () {
    $(this).toggleClass("hidden");
    $(".pw-visible").toggleClass("hidden");
    $("#password").attr("type", "text");
});
$(".pw-visible").click(function () {
    $(this).toggleClass("hidden");
    $(".pw-unvisible").toggleClass("hidden");
    $("#password").attr("type", "password");
});
