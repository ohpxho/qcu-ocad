$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 

    let table = $('#request-table').DataTable({
        ordering: false,
        dom: 'Bfrtip',
        search: {
            'regex': true
        },
        buttons: [
            'excelHtml5'
        ]
    });

    $('#export-table-btn').click(function() {
        $('.buttons-excel').click();
    });

    $('#search').on('keyup', function() {
         table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        table.draw();
    });


});