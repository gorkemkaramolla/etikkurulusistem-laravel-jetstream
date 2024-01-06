<x-datatables-layout>

    <div class="overflow-x-scroll px-4 sm:px-6 lg:px-8 py-8">
        <button class="delete-button"> delete</button>
        <table id="myTable" class="divide-gray-200 mx-auto">

        </table>
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

                // Send the newText to the server using an AJAX request or any other preferred method
                // For example, you can use Fetch API or jQuery.ajax to send a request to the server
                // with the currentEditColumn and newText data.

                // After saving, update the original text and close the modal
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
                    text: 'Excel\'\e Aktar',
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
                        dt.rows().select(!allRowsSelected); // Toggle selection for all rows
                    },
                    className: 'custom-select-all-rows-btn',
                },
            ],
        }).container().appendTo($('#myTable_wrapper .dt-buttons'));


        // Delete button functionality
        $('.delete-button').on('click', function() {
            var selectedRows = dataTable.rows({
                selected: true
            }).indexes().toArray();

            if (selectedRows.length > 0) {
                var confirmDelete = confirm('Are you sure you want to delete the selected rows?');
                if (confirmDelete) {
                    // Iterate through selected rows and perform delete action
                    selectedRows.forEach(function(rowIndex) {
                        var rowData = dataTable.row(rowIndex).data();
                        console.log(rowData);
                        var formId = rowData.id;
                        alert(formId);
                    });

                    // Redraw the table after deleting rows
                    dataTable.draw();
                }
            } else {
                alert('Please select at least one row to delete.');
            }
        });
    });
</script>




<style>
    /* Add this CSS to your existing styles */
    .custom-select-all-btn {
        background-color: green;
        color: white;
    }


    #myTable_wrapper {
        /* margin: 0 auto; */

        height: 100vh;
        padding: 20px;
    }

    #myTable {
        /* margin: 0 auto; */
        width: 100%;
        min-width: 90vw;
    }

    .buttons-colvis {
        background-color: #e44d26;
        color: #fff;
    }

    .dropdown-item {
        padding: 2px 16px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .buttons-colvis {
        background-color: #e44d26;
        color: #fff;
    }


    /* Custom animation delay for DataTables ColVis */
    .dataTables_wrapper .ColVis_MasterButton {
        transition-delay: 0.1s;
        /* Adjust the delay time as needed */
    }

    .dt-button-background {
        background-color: red
    }

    div[role="menu"] {
        position: absolute;
        margin-top: 1rem;
        max-height: 350px;
        overflow-y: auto;
        /* Enable vertical scrolling if needed */

        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 0.5rem;
        z-index: 100;
        background-color: white;
        padding: 5px;
        border-radius: 16px;

    }

    div[role="menu"]::-webkit-scrollbar {
        width: 0.5em;
    }

    div[role="menu"]::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    a.dt-button.dt-button-active {
        border-radius: 10px;
        color: #28a745;
    }



    .dt-buttons {
        display: flex;
        flex-direction: column;
        gap: 1em;
    }

    /* Media query for larger screens (flex row) */
    @media (min-width: 768px) {
        .dt-buttons {
            flex-direction: row;
        }
    }

    .dt-buttons .btn {
        background-color: #3498db;
        color: #ffffff;
        padding: 3px 6px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .dt-buttons .btn:hover {
        background-color: #2980b9;
    }

    /* Customize the colvis button */
    .buttons-colvis {
        transition: opacity 0.5s ease;
        /* Change the transition properties as needed */
        width: 100%;
    }

    .buttons-colvis:hover {
        opacity: 0.8;
        /* Change the opacity value for the hover effect */
    }

    /* Customize the colvis dropdown transition */
    .dt-buttons .buttons-columnVisibility.dropdown {
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Adjust the transition properties */
    }

    .dt-buttons .buttons-columnVisibility.dropdown:hover {
        opacity: 1;
        /* Change the opacity value for the hover effect */
        transform: scale(1.05);
        /* Change the scale value for the hover effect */
    }

    a.dt-button:not(.dt-button-active) {
        border-radius: 4px;
    }

    a.dt-button.dt-button-active:after {
        content: '\2713';
        font-size: 1.2em;
        color: black;
        margin-left: 8px;
    }

    #myTable_filter {
        padding: 20px 0px;
    }

    a.dt-button span {
        flex: 1;
    }

    .dataTables_wrapper .dt-buttons .buttons-columnVisibility.dropdown-item input[type="checkbox"] {
        display: none;
    }


    .dataTables_wrapper .dt-buttons .buttons-columnVisibility.dropdown-item:hover {
        background-color: rgb(241, 241, 241);
        border-radius: 10px;

        color: #28a745;
    }
</style>
<style>
    th {
        white-space: nowrap;
        overflow: hidden;
        color: white;
        text-overflow: ellipsis;
        border: 1px solid #ddd;
        /* Set a maximum width for the headers */
    }

    td {

        background-color: #f5f5f5;
        border: 1px solid #ddd;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        /* Set a maximum width for the cells */
    }


    .truncate-text {
        max-width: 100%;
        /* Allow the content to determine the width */
    }

    .modal {
        display: none;

        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;

        border: 1px solid #888;
        width: 80%;
    }

    .editable-area {
        border: 1px solid #ddd;
        padding: 8px;
        margin: 8px;
        min-height: 50px;
    }

    .save-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>
