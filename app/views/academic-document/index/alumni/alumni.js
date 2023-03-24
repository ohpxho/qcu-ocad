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

    function setActivityGraph(action, year) {
        const details = {
            actor: ID,
            action: action,
            year: year
        };

        const activity = getAllActivitiesByActorAndActionAndYear(details); 

        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

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
    * onclick event of action button, display action menu
    **/

    $('#action-dropdown-btn').click(function() {
        $('#action-card').toggleClass('show');
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

    
    /**
    * onclick event of filter dropdown button, toggle filter modal
    **/

    $('#filter-dropdown-btn').click(function() {
        $('#filter-card').toggleClass('show');
    });

    /**
    * onchange event for appy all checkbox, check or uncheck filter options
    **/

    $('input[name="apply-all"]').change(function() {
        if(this.checked) {
            $('.filter-checkbox').each(function() {
                $(this).prop('checked', true);
            });
        } else {
            $('.filter-checkbox').each(function() {
                $(this).prop('checked', false);
            });
        }

    });

    /**
    * onchange event for appy all checkbox, check or uncheck filter options
    **/

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/academic_document/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details.purpose_of_request);
        setViewBeneficiary(details);
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            case 'in process':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
             case 'for payment':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1');
                break;
            case 'cancelled':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1');
        }

        if(status=='rejected') status="declined";
        
        $('#status').text(status);          
    }

    function setViewDocumentRequestedProps(details) {
        let documents = []

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_honorable_dismissal_included) documents.push('Honorable Dismissal');

        $('#documents').text(documents.join(' & '));
    }

    function setViewDateCreated(dt) {
        if(dt != null) $('#date-created').text(formatDate(dt));
        else $('#date-created').text('-- -- ----');
    }

    function setViewDateCompleted(dt) {
        if(dt != null) $('#date-completed').text(formatDate(dt));
        else $('#date-completed').text('-- -- ----');
    }

    function setViewPurposeOfRequest(purpose) {
        $('#purpose').text(purpose);
    }

    function setViewBeneficiary(details) {
        if(details.is_RA11261_beneficiary == 'yes') {
            $('#beneficiary').html(`<a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
        } else {
            $('#beneficiary').html('<p class="text-slate-700">No</p>');
            
        }
    }

    function setViewAdditionalInformation(details) {
        $('#tor').addClass('hidden');
        $('#tor-price').addClass('hidden');
        $('#diploma').addClass('hidden');
        $('#gradeslip').addClass('hidden');
        $('#ctc').addClass('hidden');
        $('#other').addClass('hidden');
        
        if(details.is_tor_included) {
            $('#tor').removeClass('hidden');
            $('#tor-price').removeClass('hidden');
            $('#academic-year').text(details.tor_last_academic_year_attended);
        } 

        if(details.is_diploma_included) {
            $('#diploma').removeClass('hidden');
            $('#year-graduated').text(details.diploma_year_graduated);
        }   
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#remarks').text(remarks);
        } else {
            $('#remarks').text('...');
        }
    }

    function formatUnivSemester(sem) {
        if(sem == 1) return `${sem}st`;
        return `${sem}nd`;
    }

    function getFilenameFromPath(path) {
        path = path.split('/');
        return path[path.length-1];
    }

    function formatDate(dt) {
        const date = new Date(dt);
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        let strTime = hours + ':' + minutes + ' ' + ampm;
        return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
    }
});


