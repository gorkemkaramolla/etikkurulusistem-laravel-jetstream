<x-datatables-layout>
    <div class="overflow-x-scroll px-4 sm:px-6 lg:px-8 py-8 flex flex-col ">

        <table id="myTable" class="divide-gray-200 mx-auto">
        </table>
        <div class="flex gap-4">
            <div id="emailModal" class="modal">
                <div class="modal-content">
                    <h4>Send Email</h4>
                    <form id="emailForm" method="POST" action="/send-email">
                        @csrf
                        <input type="hidden" id="emailAddresses" name="emailAddresses" value="">
                        <div class="input-field">
                            <input id="emailMessage" type="text" name="emailMessage">
                            <label for="emailMessage">Email Message</label>
                        </div>
                        <button type="submit" class="btn">Send</button>
                    </form>
                </div>
            </div>
            <button class="send-mail-button hidden">Seçilenlere Mail Gönder</button>
            <a class="delete-button hidden">Seçilenleri Sil</a>
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a class="show-edit-button hidden">Show/Edit</a>
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

            return form;
        });

        var columnNames = Object.keys(jsonData[0]);

        // Create thead with automatically generated column names
        var theadHtml = '<thead ><tr>';
        columnNames.forEach(function(columnName) {
            theadHtml += '<th class="bg-indigo-600 ">' + columnName + '</th>';
        });
        theadHtml += '</tr></thead>';

        $('#myTable').append(theadHtml);

        var dataTable = $('#myTable').DataTable({
            data: jsonData,
            dom: 'Bfrtip',
            responsive: true,
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

                $('.show-edit-button').toggleClass('hidden', false);
                $('.show-edit-button').attr('href',
                    `/formshow` + '/' + id);

            } else {
                $('.show-edit-button').toggleClass('hidden', true);

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

        $('.send-mail-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).data().toArray();
            var emailAddresses = selectedRows.map(function(row) {
                return row.email;
            }).join(',');

            $('#emailAddresses').val(emailAddresses);
            $('#emailModal').modal('open');
        });
        // Delete button functionality
        $('.delete-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).indexes().toArray();

            if (selectedRows.length > 0) {
                var confirmDelete = confirm('Are you sure you want to delete the selected rows?');
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
