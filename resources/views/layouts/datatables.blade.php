<x-app-layout>



    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.js"></script>
    <!-- Add these lines to include ColReorder extension -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{ $slot }}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/colreorder/1.7.0/css/colReorder.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/colreorder/1.7.0/js/dataTables.colReorder.min.js"></script>
</x-app-layout>
