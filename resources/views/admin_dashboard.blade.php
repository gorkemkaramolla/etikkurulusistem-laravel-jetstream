<x-datatables-layout>
    <div class="overflow-x-hidden w-full  px-4 sm:px-6 lg:px-8 py-8 flex flex-col ">
        <table id="myTable" class="divide-gray-200 mx-auto">
        </table>
        <div class="flex w-full gap-4 ">
            <div style="display: flex; align-items:center; justify-content:center;" id="emailModal"
                class="modal absolute inset-0 bg-black bg-opacity-50 ">

                <div class="bg-white flex items-center justify-center p-6 rounded shadow-lg relative transform ">
                    <button class="close absolute right-4 text-2xl top-2">×</button>

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

            <x-button class="send-mail-button hidden">Seçilenlere Mail Gönder</x-button>
            <x-button class="delete-button hidden">Seçilenleri Sil</x-button>
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a
                class="show-edit-button hidden  flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Görüntüle/Düzenle</a>
        </div>
        <div class="etik_kurul_onaylari  flex gap-2 w-full flex-wrap md:flex-row flex-col items-center justify-center">
        </div>

    </div>

</x-datatables-layout>
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
        var jsonData = @json($forms); // Laravel Blade directive for JSON encoding
        function formatDate(date) {
            var formatter = new Intl.DateTimeFormat('en', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            return formatter.format(date);
        }
        jsonData = jsonData.map(function(form) {
            var created_at = new Date(form.created_at);
            var updated_at = new Date(form.updated_at);
            form.created_at = formatDate(created_at);
            form.updated_at = formatDate(updated_at);

            delete form.etik_kurul_onayi; // Remove the etik_kurul_onayi field

            return form;
        });

        var columnNames = Object.keys(jsonData[0]);

        // Create thead with automatically generated column names
        var theadHtml = '<thead class="bg-indigo-500 w-full text-white divide-y divide-indigo-700"><tr>';
        columnNames.forEach(function(columnName) {
            theadHtml += '<th>' + columnName + '</th>';
        });
        theadHtml += '</tr></thead>';

        var tbodyHtml = '<tbody class="divide-y divide-gray-200">';
        jsonData.forEach(function(rowData, index) {
            tbodyHtml += '<tr class="' + (index % 2 === 0 ? 'bg-white' : 'bg-gray-50') + '">';
            columnNames.forEach(function(columnName) {
                tbodyHtml += '<td>' + rowData[columnName] + '</td>';
            });
            tbodyHtml += '</tr>';
        });
        tbodyHtml += '</tbody>';

        $('#myTable').append(theadHtml);
        $('#myTable').append(tbodyHtml);


        var dataTable = $('#myTable').DataTable({
            data: jsonData,
            dom: 'Bfrtip',
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
                    data: column
                };
            }),
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
                        columns: ':visible',

                        modifier: {
                            selected: true,
                        },
                    },
                },

            ],
            scrollX: true,
        });


        dataTable.on('select deselect', function() {
            var selectedRows = dataTable.rows({
                selected: true
            });
            $('.send-mail-button').toggleClass('hidden', selectedRows.count() === 0);


            if (selectedRows.count() === 1) {
                var id = selectedRows.data()[0].id;
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
        // MAIL MODAL
        $(document).on('click', '.close', function() {
            $('#emailModal').hide();
            document.getElementById('emailModal').style.display = 'none!important';
        });
        $('.send-mail-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).data().toArray();
            var emailAddresses = selectedRows.map(function(row) {
                return row.email;
            }).join(',');
            $('#emailAddresses').html("Email Adresleri : " + emailAddresses);
            $('#emailModal').show();
        });

        // Delete button functionality
        $('.delete-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).indexes().toArray();

            if (selectedRows.length > 0) {
                var confirmDelete = confirm(
                    'Seçilen Başvuruları Silmek İstediğinize Emin Misiniz? Bu İşlem Geri Alınamaz.');
                if (confirmDelete) {
                    var formIds = selectedRows.map(function(rowIndex) {
                        return dataTable.row(rowIndex).data().id;
                    });
                    // Set the action of the form and submit it
                    $('#deleteForm').attr('action', '/delete-form/' + formIds).submit();

                }
            } else {
                alert('Please select at least one row to delete.');
            }
        });
    });
</script>


@if (session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif

@if (session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif

<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
