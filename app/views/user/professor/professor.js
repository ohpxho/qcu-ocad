$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraph('ACADEMIC_DOCUMENT_REQUEST', new Date().getFullYear());
    });

    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const docInFocus = $('#document-filter option:selected').val().toLowerCase();
        const statusInRow = (data[4] || '').toLowerCase();
        const docInRow = (data[3] || '').toLowerCase(); 
        
        if(
            (statusInFocus=='' && docInFocus=='') ||
            (statusInFocus=='' && docInRow.includes(docInFocus)) ||
            (statusInFocus==statusInRow && docInFocus=='') ||
            (statusInFocus==statusInRow && docInRow.includes(docInFocus))
        ) {
            return true;
        }

        return false;
    });
 });