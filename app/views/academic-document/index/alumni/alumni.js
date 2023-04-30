$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;

    $(window).load(function() {
        setActivityGraph('ACADEMIC_DOCUMENT_REQUEST', new Date().getFullYear());
    });

    let ongoing_table = $('#ongoing-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    let history_table = $('#history-table').DataTable({
        ordering: false,
        search: {
            'regex': true
        }
    });

    function notify() {        
        const msg = {
            action: 'DOCUMENT_REQUEST_ACTION',
            id: ID,
            department: 'registrar'
        };

        conn.send(JSON.stringify(msg));
    }

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
        history_table
            .search( this.value )
            .draw();
    });

    $('#search-btn').on('click', function() {
        history_table.draw();
    });

    /**
    * onclick event of delete button, display confirmation message
    **/

    $('.drop-btn').click(function() {
        const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        } 
        
        notify();
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
        $('#view-panel #payment-info').addClass('hidden');
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
        setViewQuantity(details.quantity);
        
        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        } else {
            $('#payment-info').removeClass('hidden');
        }
    }

    function setViewID(id) {
        $('#request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setViewStatusProps(status) {
        switch(status) {
             case 'pending':
                $('#status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#status').removeClass().addClass('bg-blue-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';

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

    function setViewQuantity(quantity) {
        $('#view-panel #quantity').text(quantity);
    }

    function setViewPaymentInformation(price) {
        $('#payment-info').removeClass('hidden');
        $('#price').text(`P ${price}`);
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

    $('.confirm-payment-btn').click(function() {
        const confirmation = window.confirm('Are you sure you want to confirm payment?');
        if(!confirmation) return false;
        
        notify();
    });

    $('.generate-oop-btn').click(function() {
        const id = $(this).attr('data-request');
  
        const request = getRequestDetails(id);

        request.done(function(result) {
            req = JSON.parse(result);

            const oop = getOrderOfPaymentDetails(id);

            oop.done(function(result) {
                order = JSON.parse(result);

                let student = '';

                student = getAlumniDetails(req.student_id);

                student.done(function(result) {
                    stud = JSON.parse(result);

                    $('#oop-modal #oop-no').text(order.id);
                    $('#oop-modal #oop-id').text(stud.id);
                    $('#oop-modal #oop-name').text(`${stud.lname} ${stud.fname} ${stud.mname}`);
                    $('#oop-modal #oop-price').text(req.price);
                    
                    let doc = '';

                    if(req.is_diploma_included) doc = 'Diploma';
                    if(req.is_honorable_dismissal_included) doc = 'Honorable Dismissal';
                    if(req.is_tor_included) doc = 'Transcript of Records';      

                    $('#oop-modal #oop-doc').text(`${req.quantity} ${doc}`);

                    $('#oop-modal').removeClass('hidden');
                });

                student.fail(function(jqXHR, textStatus) {
                    alert(result);
                });
            });


            oop.fail(function(jqXHR, textStatus) {
                alert(textStatus);
            });
        });

        request.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        return false
    });

    function getOrderOfPaymentDetails(id) {
         return $.ajax({
            url: "/qcu-ocad/academic_document/oop",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    $('#oop-exit-btn').click(function() {
        $('#oop-modal').addClass('hidden');
        return false;
    });

    $('#upload-oop').click(function() {
        const htmlElement = document.querySelector('#oop-body');

        html2canvas(htmlElement).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a5');
            pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), 0, null, 'FAST');

            pdf.save(`QCU OCAD - Order of Payment.pdf`);
        });

        return false;
    })
});


