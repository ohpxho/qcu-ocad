$(document).ready( function () {
    
    let table = $('#request-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase();
        const purposeInRow = (data[5] || '').toLowerCase();
        
        if(purposeInFocus == '' || purposeInRow == purposeInFocus) {
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
        const result = confirm("Are you sure, you want to cancel the consultation?");
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

    
    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/consultation/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStatusProps(details.status);
        setViewDateCreated(details.date_requested);
        setViewPurposeOfRequest(details);
        setViewAdviser(details.adviser_name);
        setViewDepartment(details.department);
        setViewSubject(details.subject);
        setViewProblem(details.problem);
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`( ${id} )`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1');
                break;
            case 'rejected':
                $('#view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1');
                break;
            case 'in process':
                $('#view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1');
                break;
            case 'accepted':
                $('#view-panel #for claiming').removeClass().addClass('bg-blue-500 text-wwhite rounded-md px-1 text-sm py-1');
                break;
            default:
                $('#view-panel #status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1');
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

    function setViewPurposeOfRequest(details) {
        const flag = details.purpose;
        $('#view-panel #purpose').text(getConsultationPurposeValueEquivalent(flag));
    }

    function setViewAdviser(adviser) {
        if(adviser == null || adviser.length == 0) $('#view-panel #adviser').text('N/A');
        else $('#view-panel #adviser').text(adviser);
    }

    function setViewDepartment(department) {
        $('#view-panel #department').text(department);
    }

    function setViewSubject(code) {
        if(code == null || code.length == 0) $('#view-panel #subject').text('N/A')
        else $('#view-panel #subject').text(code);
    }

    function setViewProblem(problem) {
        problem = problem.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        $('#view-panel #problem').html(problem);
    }

    function setViewAdditionalInformation(details) {
        const dt = formatDateWithoutTime(details.schedule);
        const tm = formatTime(details.start_time);
       
        $('#view-panel #schedule').text(`${dt} ${tm}`);

        $('#view-panel #mode').text(details.mode.toUpperCase());

        const sharedFile = details.shared_file_from_student; 
        
        $('#view-panel #shared-file').empty();

        if(sharedFile != null && sharedFile != '') {
            const files = sharedFile.split(',');
 
           $.each(files, function(index, item) {
                const icon = getIconOfFileExtension(getFileExtension(item));

                $('#view-panel #shared-file').append(`
                    <div class="flex gap-2 items-center">
                        <img class="h-7 w-7" src="<?php echo URLROOT?>/public/assets/img/${icon}"/>
                        <a class="w-full hover:text-blue-700 hover:underline" href="<?php echo URLROOT;?>${item}">${getFilenameFromPath(item)}</a>
                    </div>`);
            });

        } else {
            $('#view-panel #shared-file').html(`<p class="text-slate-500">No shared files</p>`);
        }
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

});


