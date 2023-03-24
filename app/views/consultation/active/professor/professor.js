$(document).ready(function() {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 

    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);

        switch(msg.action) {
            case 'RECEIVE_MESSAGE':
                checkEveryRowIfHasUnseenMessage();
                break;

        }
    };


    $(window).load(function() {
        checkEveryRowIfHasUnseenMessage();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase();
        const purposeInRow = (data[4] || '').toLowerCase();
        
        if(purposeInFocus == purposeInRow || purposeInFocus == '') {
            return true;
        }

        return false;
    });

    $('#search').on('keyup', function() {
         table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        table.draw();
    });

    function checkEveryRowIfHasUnseenMessage() {
        const data = table.rows().data();
        
        data.each(function (value, index) {
            setRowIfHasUnseenMessage(value[0], ID, index);
        }); 
    }

    function setRowIfHasUnseenMessage(consultation, user, index) {
        const hasUnseen = checkConsultationIfHasUnseenMessage(consultation, user);
        
        hasUnseen.done(function(result) {
            result = JSON.parse(result);

            if(result) {
                table.cell(index, 7).data('<div id="consultation-active-alert" class="flex h-full items-center text-white justify-center rounded-full bg-blue-600 h-5 w-5"><span class="text-center text-[10px]">!</span></div>');
            }
        });

        hasUnseen.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }
});