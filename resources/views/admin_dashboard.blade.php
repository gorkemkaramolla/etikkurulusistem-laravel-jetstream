<x-datatables-layout>

    <div class="overflow-x-scroll px-4 sm:px-6 lg:px-8 py-8">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="editable-area" contenteditable="true" id="editableArea"></div>
                <button class="save-button">Save</button>
            </div>
        </div>

        <table id="myTable" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    @foreach (\Schema::getColumnListing($forms->first()->getTable()) as $columnName)
                        <th>{{ $columnName }}</th>
                    @endforeach
                    <th>Formu düzenle</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($forms as $form)
                    <tr>
                        @foreach ($form->getAttributes() as $columnName => $value)
                            <td class="transition-colors truncate-text" data-column="{{ $columnName }}">
                                {{ $value ?? '' }}

                            </td>
                        @endforeach
                        <td>
                            <a target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-200 hover:text-gray-950 focus:outline-none  transition ease-in-out duration-50"
                                href="/formshow/{{ $form->student_no ?? '' }}/{{ $form->created_at }}">
                                Tüm Başvuruyu Görüntüle
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count(\Schema::getColumnListing($forms->first()->getTable())) }}">No data
                            available</td>
                    </tr>
                @endforelse
            </tbody>
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
    $.fx.off = true
    $(document).ready(function() {
        var dataTable = $('#myTable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        var selectedColumns = dt.columns(':visible').indexes().toArray();
                        if (selectedColumns.length === 0) {
                            alert('Please select at least one column for export.');
                        } else {
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt,
                                button, config);
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        var selectedColumns = dt.columns(':visible').indexes().toArray();
                        if (selectedColumns.length === 0) {
                            alert('Please select at least one column for export.');
                        } else {
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button,
                                config);
                        }
                    }
                },

                {
                    extend: 'colvis',
                    text: "Sütun Görünürlüğü",
                    columnText: function(dt, idx, title) {
                        return (idx + 1) + '- ' + title;
                    },


                }
            ],


            scrollX: true,
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var maxLength = 32; // Change this to your desired character limit

        var tdElements = document.querySelectorAll('tbody .truncate-text');
        tdElements.forEach(function(td) {
            td.style.maxWidth = maxLength + 'ch';
        });
    });
</script>

<style>
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

        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 0.5rem;
        z-index: 100;
        background-color: white;
        padding: 5px;
        border-radius: 16px;

    }

    a.dt-button.dt-button-active {
        border-radius: 10px;
        color: #28a745;
    }



    .dt-buttons {
        display: flex;
        gap: 1em;
    }

    .dt-buttons .btn {
        background: #092635;
        padding: 6px 12px;
        color: white;
        border-radius: 20px;


    }

    /* Customize the colvis button */
    .buttons-colvis {
        transition: opacity 0.5s ease;
        /* Change the transition properties as needed */
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
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse
    }

    .truncate-text {
        max-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
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
