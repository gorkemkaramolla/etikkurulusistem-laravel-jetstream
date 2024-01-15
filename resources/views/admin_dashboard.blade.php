<x-datatables-layout>
    <div class="w-full py-4  flex flex-col ">

        <table id="myTable" class="divide-gray-200 ">
        </table>
        <div class="flex  gap-4 px-5">
            <div style="display: flex; align-items:center; justify-content:center;" id="emailModal"
                class="modal hidden absolute inset-0 bg-black bg-opacity-50 ">

                <div class="bg-white flex items-center justify-center p-6 rounded shadow-lg relative transform ">
                    <button class="close absolute right-4 text-2xl top-2">×</button>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <div>
                        <form id="emailForm" class="p-4">
                            @csrf
                            <label id="emailAddresses">Email Addresses:
                            </label>
                            <textarea name="email-content" class="w-full h-16 p-2  resize-none"></textarea>
                            <button type="submit" class="mt-4 bg-indigo-600 text-white p-2 rounded">Send Email</button>
                        </form>
                    </div>
                </div>
            </div>

            <x-button class=" px-4 send-mail-button hidden">Seçilenlere Mail Gönder</x-button>
            <x-button class=" delete-button hidden">Seçilenleri Sil</x-button>
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a target="_blank"
                class="show-edit-button hidden  flex items-center  px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Görüntüle/Düzenle</a>
        </div>
        <div class="etik_kurul_onaylari  flex gap-2 w-full flex-wrap md:flex-row flex-col items-center justify-center">
        </div>
        <div class="p-5 gap-4 flex md:flex-row flex-col">
            <div class="">
                Sekreterlik Onayı Bekleyen Başvuru Sayısı: {{ $forms->where('stage', 'sekreterlik')->count() }}
            </div>
            <div class="">
                Etik Kurul Onayı Bekleyen Başvuru Sayısı: {{ $forms->where('stage', 'etik_kurul')->count() }}
            </div>
            <div class="">
                Reddedilmiş Başvuru Sayısı: {{ $forms->where('stage', 'reddedildi')->count() }}
            </div>
            <div class="">
                Onaylanan Başvuru Sayısı: {{ $forms->where('stage', 'onaylandi')->count() }}
            </div>
            <div class="">
                Düzeltme Beklenen Başvuru Sayısı: {{ $forms->where('stage', 'duzeltme')->count() }}
            </div>
        </div>
    </div>

</x-datatables-layout>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #dc3545;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        background: #dc3545 !important;
        color: white !important;
    }

    li.paginate_button.page-item.active {
        background-color: #dc3545 !important;
        color: white !important;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var maxLength = 32; // Change this to your desired character limit
        var currentEditColumn = null;

        var tdElements = document.querySelectorAll('tbody .truncate-text');
        var modal = document.getElementById('myModal');
        var editableArea = document.getElementById('editableArea');

        tdElements.forEach(function(td) {
            td.addEventListener('click', function() {
                currentEditColumn = td.dataset.column;
                var originalText = td.textContent.trim();

                editableArea.textContent = originalText;
                modal.style.display = 'block';
            });
        });

        // Save button functionality
        document.querySelector('.save-button').addEventListener('click', function() {
            if (currentEditColumn) {
                var newText = editableArea.textContent;


                var td = document.querySelector('td[data-column="' + currentEditColumn + '"]');
                td.dataset.originalText = newText;
                td.textContent = newText.substring(0, maxLength) + '...';
                modal.style.display = 'none';
                currentEditColumn = null;
            }
        });

        // Close the modal when the close button is clicked
        document.querySelector('.close').addEventListener('click', function() {
            modal.style.display = 'none';
            currentEditColumn = null;
        });

        // Close the modal when clicking outside the modal
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                currentEditColumn = null;
            }
        });
    });
</script>

<script type="text/javascript" class="init">
    $("#emailModal").hide();
    $.fx.off = true;

    $(document).ready(function() {
        var jsonData = @json($forms);
        var columnNamesTurkish = @json(config('columnnames'));
        jsonData = jsonData.map(function(item) {
            var newItem = {};
            for (var key in item) {
                if (item.hasOwnProperty(key) && columnNamesTurkish.hasOwnProperty(key)) {
                    newItem[columnNamesTurkish[key]] = item[key];
                }
            }
            return newItem;
        });

        function formatDate(date) {
            var formatter = new Intl.DateTimeFormat('en', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            return formatter.format(date);
        }

        jsonData = jsonData.map(function(form) {
            var created_at = new Date(form['Oluşturulma Tarihi']);
            var updated_at = new Date(form['Güncelleme Tarihi']);
            form['Oluşturulma Tarihi'] = formatDate(created_at);
            form['Güncelleme Tarihi'] = formatDate(updated_at);

            delete form['etik_kurul_onayi']; // Remove the etik_kurul_onayi field

            return form;
        });

        var columnNames = Object.keys(jsonData[0]);
        console.log(columnNames);

        // Create thead with automatically generated column names
        var theadHtml = '<thead class="bg-indigo-500 w-full text-white divide-y divide-indigo-700"><tr>';
        columnNames.forEach(function(columnName) {
            theadHtml += '<th>' + columnName + '</th>';
        });
        theadHtml += '</tr></thead>';
        $('#myTable').append(theadHtml);
        var tbodyHtml = '<tbody class="divide-y divide-gray-200">';



        jsonData.forEach(function(rowData, index) {
            tbodyHtml += '<tr class="' + (index % 2 === 0 ? 'bg-white' : 'bg-gray-50') + '">';
            columnNames.forEach(function(columnName) {
                tbodyHtml += '<td>' + rowData[columnName] + '</td>';
            });
            tbodyHtml += '</tr>';
        });
        tbodyHtml += '</tbody>';

        // Append tbody to the existing table
        $('#myTable').append(tbodyHtml);


        var dataTable = $('#myTable').DataTable({
            data: jsonData,
            dom: 'Bfrtip',
            language: {
                info: "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
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
                    previous: "Önceki"
                },
                select: {
                    rows: {
                        _: " %d satır seçildi",
                        0: "Satır seçmek için satıra tıklayınız",
                    }
                }

            },
            colReorder: true,
            responsive: true,
            stateSave: true,

            select: {
                style: 'multi',
                blurable: false,
                event: 'click',

            },
            columns: columnNames.map(function(column) {
                return {
                    data: column,
                    width: '100px', // Set your desired fixed width here
                };
            }),
            search: {
                caseInsensitive: false,
                smart: false,
                regex: true,
            },

            autoWidth: false,

            paging: true,
            buttons: [{
                    extend: 'copyHtml5',
                    text: "Kopyala",
                    exportOptions: {
                        columns: [0, ':visible'],
                        modifier: {
                            selected: true,

                        },
                    },
                },
                {
                    extend: 'excelHtml5',
                    text: 'Seçilenleri Excel\'\e Aktar',
                    exportOptions: {
                        format: {
                            header: function(data, columnIdx) {
                                var html = $.parseHTML(data);
                                var text = $(html).find('input').remove().end().text().trim();
                                return text;
                            },


                            body: function(data, row, column, node) {
                                // Exclude columns with input elements
                                if ($(node).find('input').length > 0) {
                                    return '';
                                } else {
                                    return data;
                                }
                            }
                        },
                        columns: ':visible',
                        modifier: {
                            selected: true,
                        },
                    },
                },

            ],
            scrollX: true,

            initComplete: function() {
                var api = this.api();
                api.columns().every(function() {
                    var column = this;
                    var columnIndex = column.index();
                    var title = $(column.header()).text();

                    // Create a container for the search input and button
                    var container = $(
                        '<div class="gap-3 w-full flex flex-col items-center" ></div>');

                    var searchValue = ''; // Initialize searchValue

                    // If state is loaded, get the search value
                    if (api.state.loaded()) {
                        searchValue = api.state.loaded().columns[columnIndex].search.search;
                    }

                    // Create the search input
                    var input = $(
                            '<input class="rounded-md py-1" type="search" placeholder="' +
                            title +
                            '" value="' + searchValue + '" />')
                        .on('click', function(e) {
                            e
                                .stopPropagation(); // Prevent click propagation to the th element
                        })
                        .on('keyup change', function() {
                            if (column.search() !== this.value) {
                                column.search(this.value.trim()).draw();
                            }
                        })
                        .on('search', function() {
                            if (!this.value) {
                                column.search('').draw();
                            }
                        });

                    // Append the input and button to the container
                    container.append('<span class="">' + title + '</span>').append(input);

                    // Append the container to the column header
                    $(column.header()).empty().append(container);
                });
            }


        });
        dataTable.order(["0", 'asc']).draw();




        dataTable.on('select deselect', function() {
            var selectedRows = dataTable.rows({
                selected: true
            });
            $('.send-mail-button').toggleClass('hidden', selectedRows.count() === 0);


            if (selectedRows.count() === 1) {
                var id = selectedRows.data()[0].ID;
                var stage = selectedRows.data()[0].stage;
                $('.etik_kurul_onaylari').toggleClass('hidden', false);
                $('.show-edit-button').toggleClass('hidden', false);
                $('.show-edit-button').attr('href',
                    `/formshow` + '/' + id);
                if (stage === "etik_kurul" || stage === "reddedildi" || stage === "onaylandi") {

                    $.ajax({
                        url: `/getEtikKuruluOnayiByFormId` + '/' + id,
                        type: 'GET',
                        success: function(response) {
                            var html =
                                '<div class="w-full block flex justify-center items-center text-lg font-bold mb-2">Form ID: ' +
                                id +
                                '</div>';
                            html += $.map(response, function(value, key) {
                                return '<div class="flex flex-col  bg-white shadow-md rounded-lg p-4 mb-4 w-64 ">' +
                                    '<h3 class="text-sm font-bold mb-2 truncate">' +
                                    value.username + ' ' + value.lastname +
                                    '</h3>' +
                                    '<p class="text-xs text-gray-700">Onay Durumu: <span class="font-semibold">' +
                                    value.onay_durumu + '</span></p>' +
                                    '</div>';
                            }).join('');
                            $('.etik_kurul_onaylari').empty().html(html);
                        },
                        error: function(error) {
                            alert(JSON.stringify(error));
                        }
                    });
                }
            } else {
                $('.show-edit-button').toggleClass('hidden', true);
                $('.etik_kurul_onaylari').toggleClass('hidden', true);

                $('.etik_kurul_onaylari').empty();

            }

            if (selectedRows.count() > 0) {
                $('.delete-button').toggleClass('hidden', false);
            } else {
                $('.delete-button').toggleClass('hidden', true);
            }

        });
        var selectAllButton = new $.fn.dataTable.Buttons(dataTable, {
            buttons: [{
                    extend: 'colvis',
                    text: 'Sütun Seç',
                    className: 'custom-colvis-btn',
                },
                {
                    text: 'Tüm Sütunları Seç/Seçimi Kaldır',
                    action: function(e, dt, node, config) {

                        // Toggle between showing and hiding all columns
                        var allColumnsVisible = dt.columns().visible().toArray().every(
                            function(visible) {
                                return visible;
                            });
                        dt.columns().visible(!allColumnsVisible);

                    },
                    className: 'custom-select-all-btn', // Initial class
                },
                {
                    text: 'Tüm Satırları Seç/Seçimi Kaldır',
                    action: function(e, dt, node, config) {
                        var allRowsSelected = dt.rows({
                            selected: true
                        }).count() === dt.rows().count();
                        dt.rows().select(!
                            allRowsSelected); // Toggle selection for all rows
                    },
                    className: 'custom-select-all-rows-btn',
                },
            ],
        }).container().appendTo($('#myTable_wrapper .dt-buttons'));



        // EMAIL MODAL
        let emailContent;

        function openEmailModal(emailAddresses) {
            Swal.fire({
                title: 'Send Email',
                html: `
            <form id="emailForm" class="text-start space-y-4">
                <p class="text-sm text-gray-500">${emailAddresses}</p>
                <label for="email-subject" class="block text-sm font-medium text-gray-700">Konu</label>
                <input type="text" id="email-subject" name="email-subject" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Subject">
                <label for="email-content" class="block text-sm font-medium text-gray-700">Mesaj</label>
                <textarea id="email-content" name="email-content" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </form>
        `,
                confirmButtonText: 'Send Email',
                showCloseButton: true,
                focusConfirm: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                preConfirm: () => {
                    let emailSubject = Swal.getPopup().querySelector('#email-subject').value;
                    let emailContent = Swal.getPopup().querySelector('#email-content').value;
                    if (!emailSubject || !emailContent) {
                        Swal.showValidationMessage(`Please enter both subject and content.`);
                    }
                    return {
                        emailSubject: emailSubject,
                        emailContent: emailContent
                    };
                },
                onClose: () => {
                    emailContent = '';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let emailSubject = result.value.emailSubject;
                    let emailContent = result.value.emailContent;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send it!'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/api/send-email',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                data: {
                                    emails: emailAddresses,
                                    subject: emailSubject,
                                    message: emailContent
                                },
                                success: function(response) {
                                    console.log(response);
                                    Swal.fire(
                                        'Success!',
                                        'Emails have been sent successfully.',
                                        'success'
                                    );
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while sending emails.',
                                        'error'
                                    );
                                }
                            });
                        } else {
                            openEmailModal(emailAddresses);
                        }
                    });
                }
            });
        }

        $('.send-mail-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).data().toArray();
            var emailAddresses = selectedRows.map(function(row) {
                return row.Email;
            }).join(',');

            openEmailModal(emailAddresses);
        });




        // Delete button functionality
        $('.delete-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).indexes().toArray();

            if (selectedRows.length > 0) {
                Swal.fire({
                    title: "Seçilen Başvuruları Silmek İstediğinize Emin Misiniz?",
                    text: "Bu İşlem Geri Alınamaz.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: 'Hayır, iptal!',
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formIds = selectedRows.map(function(rowIndex) {
                            return dataTable.row(rowIndex).data().ID;
                        });
                        // Set the action of the form and submit it
                        $('#deleteForm').attr('action', '/delete-form/' + formIds).submit();
                    }
                });
            } else {
                Swal.fire("Hata!", "Lütfen silmek için en az bir satır seçin.", "error");
            }
        });
    });
</script>


@if (session('success'))
    <script>
        Swal.fire({
            title: "Başarılı",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: 'Tamam',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: "Hata",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: 'Tamam',
        });
    </script>
@endif

<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
