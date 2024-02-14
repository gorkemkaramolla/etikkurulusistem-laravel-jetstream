$(document).ready(function () {
    var maxLength = 32; // Change this to your desired character limit
    var currentEditColumn = null;

    var tdElements = document.querySelectorAll("tbody .truncate-text");
    var modal = document.getElementById("myModal");
    var editableArea = document.getElementById("editableArea");

    tdElements.forEach(function (td) {
        td.addEventListener("click", function () {
            currentEditColumn = td.dataset.column;
            var originalText = td.textContent.trim();

            editableArea.textContent = originalText;
            modal.style.display = "block";
        });
    });
    // Save button functionality
    $(document).ready(function () {
        var saveButton = document.querySelector(".save-button");

        if (saveButton) {
            saveButton.addEventListener("click", function () {
                if (currentEditColumn) {
                    var newText = editableArea.textContent;

                    var td = document.querySelector(
                        'td[data-column="' + currentEditColumn + '"]'
                    );
                    td.dataset.originalText = newText;
                    td.textContent = newText.substring(0, maxLength) + "...";
                    modal.style.display = "none";
                    currentEditColumn = null;
                }
            });
        } else {
            console.log("Save button not found");
        }
    });

    // Close the modal when the close button is clicked
    var closeButton = document.querySelector(".close");

    if (closeButton) {
        closeButton.addEventListener("click", function () {
            modal.style.display = "none";
            currentEditColumn = null;
        });
    } else {
        console.log("Close button not found");
    }

    // Close the modal when clicking outside the modal
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            currentEditColumn = null;
        }
    });
});
$("#emailModal").hide();
$.fx.off = true;
$(document).ready(function () {
    var jsonData = phpForms;
    var columnNamesTurkish = turkishColumnNames;
    jsonData = Array.isArray(jsonData) ? jsonData : Object.values(jsonData);
    var columnNamesTurkish = turkishColumnNames;
    jsonData = jsonData.map(function (item) {
        var newItem = {};
        for (var key in item) {
            if (
                item.hasOwnProperty(key) &&
                columnNamesTurkish.hasOwnProperty(key)
            ) {
                newItem[columnNamesTurkish[key]] = item[key];
            }
        }
        return newItem;
    });

    function formatDate(date) {
        var formatter = new Intl.DateTimeFormat("en", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            hour12: false,
        });
        return formatter.format(date);
    }
    jsonData = jsonData.map(function (form) {
        var created_at = new Date(form["Oluşturulma Tarihi"]);
        var updated_at = new Date(form["Güncelleme Tarihi"]);
        form["Oluşturulma Tarihi"] = formatDate(created_at);
        form["Güncelleme Tarihi"] = formatDate(updated_at);

        delete form["etik_kurul_onayi"]; // Remove the etik_kurul_onayi field

        return form;
    });

    var columnNames = [];
    if (jsonData.length > 0) {
        columnNames = Object.keys(jsonData[0]);
    }
    var theadHtml =
        '<thead class="bg-indigo-500 w-full text-white divide-y divide-indigo-700"><tr>';
    columnNames.forEach(function (columnName) {
        theadHtml += "<th>" + columnName + "</th>";
    });
    theadHtml += "</tr></thead>";
    $("#myTable").append(theadHtml);
    var tbodyHtml = '<tbody class="divide-y divide-gray-200">';

    jsonData.forEach(function (rowData, index) {
        tbodyHtml +=
            '<tr class="' +
            (index % 2 === 0 ? "bg-white" : "bg-gray-50") +
            '">';
        columnNames.forEach(function (columnName) {
            tbodyHtml += "<td>" + rowData[columnName] + "</td>";
        });
        tbodyHtml += "</tr>";
    });
    tbodyHtml += "</tbody>";
    jsonData.forEach((rowData, index) => {
        if (rowData["Aşama"] === "onaylandi") {
            $(".show-edit-button").html("Formu Görüntüle");
        }
    });
    // Append tbody to the existing table
    $("#myTable").append(tbodyHtml);

    // Show loading text
    $("#loading").show();

    var dataTable = $("#myTable").DataTable({
        data: jsonData,
        dom: "Bfrtip",
        language: {
            info: "Toplam _TOTAL_ adet başvuru ",
            infoEmpty: "Gösterilecek hiç kayıt yok.",
            infoFiltered: "(toplamda _MAX_ kayıttan filtrelenmiş)",
            lengthMenu: "_MENU_ kayıt göster",
            loadingRecords: "Yükleniyor...",
            processing: "İşleniyor...",
            search: "Ara:",
            zeroRecords: "Eşleşen kayıt bulunamadı",
            paginate: {
                first: "İlk",
                last: "Son",
                next: "Sonraki",
                previous: "Önceki",
            },
            select: {
                rows: {
                    _: " %d satır seçildi",
                    0: "Satır seçmek için satıra tıklayınız",
                },
            },
        },
        colReorder: true,
        responsive: true,
        stateSave: true,

        select: {
            style: "multi",
            blurable: false,
            event: "click",
        },
        columns: columnNames.map(function (column) {
            return {
                data: column,
                width: "100px", // Set your desired fixed width here
            };
        }),

        search: {
            caseInsensitive: false,
            smart: false,
            regex: true,
        },

        autoWidth: false,

        paging: true,

        buttons: [
            {
                extend: "print",
                text: "Yazdır",
                exportOptions: {
                    columns: [0, ":visible"],
                    modifier: {
                        selected: true,
                    },
                },
            },
            {
                extend: "copyHtml5",
                text: "Kopyala",
                exportOptions: {
                    columns: [0, ":visible"],
                    modifier: {
                        selected: true,
                    },
                },
            },
            {
                extend: "excelHtml5",
                text: "Seçilenleri Excel'e Aktar",
                filename: "etikkurul_tablo", // Add this line
                exportOptions: {
                    format: {
                        header: function (data, columnIdx) {
                            var html = $.parseHTML(data);
                            var text = $(html)
                                .find("input")
                                .remove()
                                .end()
                                .text()
                                .trim();
                            return text;
                        },

                        body: function (data, row, column, node) {
                            // Exclude columns with input elements
                            if ($(node).find("input").length > 0) {
                                return "";
                            } else {
                                return data;
                            }
                        },
                    },
                    columns: ":visible",
                    modifier: {
                        selected: true,
                    },
                },
            },
        ],

        scrollX: true,

        initComplete: function () {
            // Hide loading text after the DataTable has been initialized
            $("#loading").hide();

            var api = this.api();
            api.columns().every(function () {
                var column = this;
                var columnIndex = column.index();
                var title = $(column.header()).text();

                // Create a container for the search input and button
                var container = $(
                    '<div class="gap-3 w-full flex flex-col items-center" ></div>'
                );

                var searchValue = ""; // Initialize searchValue

                // If state is loaded, get the search value
                if (api.state.loaded()) {
                    searchValue =
                        api.state.loaded().columns[columnIndex].search.search;
                }

                // Create the search input
                var input = $(
                    '<input class="rounded-md py-1" type="search" placeholder="' +
                        title +
                        '" value="' +
                        searchValue +
                        '" />'
                )
                    .on("click", function (e) {
                        e.stopPropagation(); // Prevent click propagation to the th element
                    })
                    .on("keyup change", function () {
                        if (column.search() !== this.value) {
                            column.search(this.value.trim()).draw();
                        }
                    })
                    .on("search", function () {
                        if (!this.value) {
                            column.search("").draw();
                        }
                    });

                // Append the input and button to the container
                container
                    .append('<span class="">' + title + "</span>")
                    .append(input);

                // Append the container to the column header
                $(column.header()).empty().append(container);
            });
        },
    });
    // Store the original data in a separate variable

    var originalData = jsonData.slice();

    // Set the selected option from localStorage when the page loads
    var savedValue = localStorage.getItem("selectedOption");
    if (savedValue) {
        $(".filterStage").val(savedValue).trigger("change");
    }

    $(".filterStage").on("change", function () {
        let status = $(this).val();

        // Save the selected option to localStorage when the select value changes
        localStorage.setItem("selectedOption", status);

        if (status === "all") {
            dataTable.clear().rows.add(originalData).search("").draw();
        } else if (status === "user_onay_bekleyen") {
            $.ajax({
                url: `api/user/${user_id}/pending-approval-forms`,
                type: "GET",
                success: function (response) {
                    var filteredData = originalData.filter(function (item) {
                        return response
                            .map(String)
                            .includes(String(item["ID"]));
                    });

                    // Clear the DataTable, add the filtered data, and redraw the table
                    dataTable.clear().rows.add(filteredData).draw();
                },
                error: function (error) {
                    alert(JSON.stringify(error));
                },
            });
        } else {
            var filteredData = originalData.filter(function (item) {
                return item["Aşama"] === status;
            });

            // Clear the DataTable, add the filtered data, and redraw the table
            dataTable.clear().rows.add(filteredData).draw();
        }
    });

    dataTable.order(["2", "desc"]).draw();
    dataTable.on("select deselect", function () {
        var selectedRows = dataTable.rows({
            selected: true,
        });
        $(".send-mail-button").toggleClass(
            "hidden",
            selectedRows.count() === 0
        );
        if (selectedRows.count() === 1) {
            var id = selectedRows.data()[0].ID;
            var stage = selectedRows.data()[0].Aşama;
            $(".onay-div").toggleClass("hidden", false);

            $(".etik_kurul_onaylari").toggleClass("hidden", false);
            $(".show-edit-button").toggleClass("hidden", false);
            $(".show-querystage-button").toggleClass("hidden", false);
            $(".show-querystage-button").attr(
                "href",
                `/query-etikkurul` + "/" + id
            );

            $(".show-edit-button").attr("href", `/formshow` + "/" + id);
            if (stage === "etik_kurul" || stage === "reddedildi") {
                $.ajax({
                    url: `/api/getEtikKuruluOnayiByFormId` + "/" + id,
                    type: "GET",
                    success: function (response) {
                        var html =
                            '<h2 class="w-full  text-center text-2xl font-bold py-4">Etik Kurulu Onayları</h2>';
                        $.each(response, function (key, value) {
                            var onayDurumuText;
                            switch (value.onay_durumu) {
                                case "onaylandi":
                                    onayDurumuText = "Onayladı";
                                    break;
                                case "reddedildi":
                                    onayDurumuText =
                                        "Reddedildi : " + value.decide_reason;
                                    break;
                                case "bekleme":
                                    onayDurumuText = "Bekleme";
                                    break;
                                case "duzeltme":
                                    onayDurumuText = "Düzeltme";
                                    break;
                                default:
                                    onayDurumuText = value.onay_durumu;
                            }
                            html +=
                                '<details open class="mb-2 text-sm max-w-[150px] rounded shadow ' +
                                (value.onay_durumu === "onaylandi"
                                    ? "bg-green-500 text-white"
                                    : value.onay_durumu === "reddedildi"
                                    ? "bg-red-500 text-white"
                                    : "bg-white text-black") +
                                ' word-wrap: break-word;">';
                            html +=
                                "<summary class='cursor-pointer text-sm p-2 bg-gray-200 rounded-t'><strong class='text-gray-700'>" +
                                value.username +
                                " " +
                                value.lastname +
                                "</strong></summary>";
                            html +=
                                '<p class="p-2" style="max-width: 200px; word-wrap: break-word;">' +
                                onayDurumuText +
                                "</p>";

                            // Add decision reason
                            if (value.decision_reason) {
                                html +=
                                    '<p class="p-2 break-words ">' +
                                    value.decision_reason +
                                    "</p>";
                            }

                            html += "</details>";
                        });
                        $(".etik_kurul_onaylari").empty().html(html);
                    },
                    error: function (error) {
                        alert(JSON.stringify(error));
                    },
                });
            }
        } else {
            $(".show-edit-button").toggleClass("hidden", true);
            $(".etik_kurul_onaylari").toggleClass("hidden", true);
            $(".show-querystage-button").toggleClass("hidden", true);

            $(".etik_kurul_onaylari").empty();
        }

        if (selectedRows.count() > 0) {
            $(".delete-button").toggleClass("hidden", false);
        } else {
            $(".delete-button").toggleClass("hidden", true);
        }
    });
    var selectAllButton = new $.fn.dataTable.Buttons(dataTable, {
        buttons: [
            {
                extend: "colvis",
                text: "Sütun Seç",
                className: "custom-colvis-btn",
            },
            {
                text: "Tüm Sütunları Seç/Seçimi Kaldır",
                action: function (e, dt, node, config) {
                    // Toggle between showing and hiding all columns
                    var allColumnsVisible = dt
                        .columns()
                        .visible()
                        .toArray()
                        .every(function (visible) {
                            return visible;
                        });
                    dt.columns().visible(!allColumnsVisible);
                },
                className: "custom-select-all-btn", // Initial class
            },
            {
                text: "Tüm Satırları Seç/Seçimi Kaldır",
                action: function (e, dt, node, config) {
                    var allRowsSelected =
                        dt
                            .rows({
                                selected: true,
                            })
                            .count() === dt.rows().count();
                    dt.rows().select(!allRowsSelected); // Toggle selection for all rows
                },
                className: "custom-select-all-rows-btn",
            },
        ],
    })
        .container()
        .appendTo($("#myTable_wrapper .dt-buttons"));
    let emailContent;

    function openEmailModal(emailAddresses) {
        Swal.fire({
            title: "Send Email",
            html: `
            <form id="emailForm" class="text-start space-y-4">
                <p class="text-sm text-gray-500">${emailAddresses}</p>
                <label for="email-subject" class="block text-sm font-medium text-gray-700">Konu</label>
                <input type="text" id="email-subject" name="email-subject" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Subject">
                <label for="email-content" class="block text-sm font-medium text-gray-700">Mesaj</label>
                <textarea id="email-content" name="email-content" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </form>
        `,
            confirmButtonText: "Send Email",
            showCloseButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            preConfirm: () => {
                let emailSubject =
                    Swal.getPopup().querySelector("#email-subject").value;
                let emailContent =
                    Swal.getPopup().querySelector("#email-content").value;
                if (!emailSubject || !emailContent) {
                    Swal.showValidationMessage(
                        `Please enter both subject and content.`
                    );
                }
                return {
                    emailSubject: emailSubject,
                    emailContent: emailContent,
                };
            },
            onClose: () => {
                emailContent = "";
            },
        }).then((result) => {
            if (result.isConfirmed) {
                let emailSubject = result.value.emailSubject;
                let emailContent = result.value.emailContent;
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, send it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/api/send-email",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            data: {
                                emails: emailAddresses,
                                subject: emailSubject,
                                message: emailContent,
                            },
                            success: function (response) {
                                console.log(response);
                                Swal.fire(
                                    "Success!",
                                    "Emails have been sent successfully.",
                                    "success"
                                );
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                Swal.fire(
                                    "Error!",
                                    "An error occurred while sending emails.",
                                    "error"
                                );
                            },
                        });
                    } else {
                        openEmailModal(emailAddresses);
                    }
                });
            }
        });
    }

    $(".send-mail-button").on("click", function () {
        var selectedRows = dataTable
            .rows({
                selected: true,
            })
            .data()
            .toArray();
        var emailAddresses = selectedRows
            .map(function (row) {
                return row.Email;
            })
            .join(",");

        openEmailModal(emailAddresses);
    });
});
