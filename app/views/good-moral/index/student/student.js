$(document).ready( function () {
    const purpose_dict = [
        'Scholarship / Financial Assitance',
        'Enrollment / Transfer To Other School',
        'Work / Employment',
        'Masteral / Graduate Studies',
        'PNP Application',
        'On The Job Application / Intership',
        'Application For Second Course (for graduate only)',
        'Others'
    ];
    
    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[4] || '').toLowerCase();
        
        if(statusInFocus == statusInRow || statusInFocus == '') {
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

    /**
    * onclick event of delete button, display confirmation message
    **/

    $('.drop-btn').click(function() {
        const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        } 
        
    });

    /**
    * onclick event of view button, display view panel
    **/

    $('.view-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
    }); 

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    $('#add-request-btn').click(function() {
    	 $('#add-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#add-exit-btn').click(function() {
    	 $('#add-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('.edit-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setEditPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
    });

    $('#edit-exit-btn').click(function() {
         $('#edit-panel').removeClass('right-0').toggleClass('-right-full');
    });

    $('#add-panel select[name="purpose"] ').change(function() {
    	const selectedOption = $('#add-panel select[name="purpose"] option:selected').val();
    	const othersOptionValue = 8;
    	if(selectedOption == othersOptionValue) {
            $('#add-panel #others-hidden-input').removeClass('hidden');
            $('#add-panel input[name="other-purpose"]').val('');
        } else $('#add-panel #others-hidden-input').addClass('hidden');
    });

    $('#edit-panel select[name="purpose"] ').change(function() {
        const selectedOption = $('#edit-panel select[name="purpose"] option:selected').val();
        const othersOptionValue = 8;
        if(selectedOption == othersOptionValue) {
            $('#edit-panel #others-hidden-input').removeClass('hidden');
            $('#edit-panel input[name="other-purpose"]').val('');
        } else $('#edit-panel #others-hidden-input').addClass('hidden');
    });

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/good_moral/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps();
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewIdentificationDocument(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(id);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#view-panel #status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1');
                break;
            case 'rejected':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            case 'in process':
                $('#view-panel #status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1');
                break;
            default:
                $('#view-panel #status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1');
        }

        $('#view-panel #status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        $('#view-panel #documents').text('Good Moral');
    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#view-panel #date-created').text(formatDate(dt));
        else $('#view-panel #date-created').text('-- -- ----');
    }

    function setViewDateCompleted(dt) {
        if(dt != null) $('#view-panel #date-completed').text(formatDate(dt));
        else $('#view-panel #date-completed').text('-- -- ----');
    }

    function setViewPurposeOfRequest(details) {
        const othersOptionValue = 8;
        if(details.purpose == othersOptionValue) $('#view-panel #purpose').text(details.other_purpose);
        else $('#view-panel #purpose').text(purpose_dict[purpose]);
    }

    function setViewIdentificationDocument(details) {
    	const doc = details.identification_document;
        $('#view-panel #identification-document').html(`<a class="hover:underline text-sky-700" href="<?php echo URLROOT;?>${doc}">${getFilenameFromPath(doc)}</a> `);
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

    function setEditPanel(details) {
        $('#edit-panel #request-id').text(details.id);
         $('#edit-panel input[name="request-id"]').val(details.id);
         $('#edit-panel select[name="purpose"] option').each(function() {
            const optionValue = $(this).val();
            const othersOptionValue = 8;

            if(optionValue == details.purpose) {
                $(this).prop('selected', true);
                if(optionValue == othersOptionValue) {
                    $('#edit-panel #others-hidden-input').removeClass('hidden');
                    $('#edit-panel input[name="other-purpose"]').val(details.other_purpose);
                } else {
                    $('#edit-panel #others-hidden-input').addClass('hidden');
                }
            }


         });
         $('#uploaded-file').text(getFilenameFromPath(details.identification_document));
         $('#uploaded-file').prop('href', `${<?php echo json_encode(URLROOT) ?>}${details.identification_document}`);
    }

});


