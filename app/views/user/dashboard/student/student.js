$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;
    const ongoing_academic = <?php echo json_encode($data['inprogress-academic']) ?>;
    const ongoing_moral = <?php echo json_encode($data['inprogress-moral']) ?>;
    const ongoing_account = <?php echo json_encode($data['inprogress-account']) ?>;

    $(window).load(function() {
        setActivityGraphOfDocument(new Date().getFullYear());
        setActivityGraphOfConsultation('CONSULTATION', new Date().getFullYear());
    });

    function setActivityGraphOfDocument(year) {
        const details = {
            actor: ID,
            year: year
        };

        const activity = getAllDocumentActivitiesByActorAndActionAndYear(details); 

        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph-document', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setActivityGraphOfConsultation(action, year) {
        const details = {
            actor: ID,
            action: action,
            year: year
        };

        const activity = getAllActivitiesByActorAndActionAndYear(details); 
 
        activity.done(function(result) {
            result = JSON.parse(result);
            const data = getFrequencyOfActivities(result);
            renderCalenderActivityGraph('calendar-activity-graph-consultation', year, data);
        });

        activity.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    $('#completed-req-summary-btn').click(function() {
        $('#completed-req-summary-modal').removeClass('hidden');
    });

    $('#completed-req-summary-exit-btn').click(function() {
        $('#completed-req-summary-modal').addClass('hidden');
    });

    $('#rejected-req-summary-btn').click(function() {
        $('#rejected-req-summary-modal').removeClass('hidden');
    });

    $('#rejected-req-summary-exit-btn').click(function() {
        $('#rejected-req-summary-modal').addClass('hidden');
    });

    $('#cancelled-req-summary-btn').click(function() {
        $('#cancelled-req-summary-modal').removeClass('hidden');
    });

    $('#cancelled-req-summary-exit-btn').click(function() {
        $('#cancelled-req-summary-modal').addClass('hidden');
    });

    $('.academic-view-btn').click(function() {
        const id = $(this).attr('data-id');
        
        const details = ongoing_academic.find(o => o.id == id);

        setAcademicViewPanel(details);

        $('#academic-view-panel').removeClass('-right-full').toggleClass('right-0');
    });

    function setAcademicViewPanel(details) {
        setAcademicViewID(details.id);
        setAcademicViewStatusProps(details.status);
        setAcademicViewDocumentRequestedProps(details);
        setAcademicViewDateCreated(details.date_created);
        setAcademicViewDateCompleted(details.date_completed);
        setAcademicViewPurposeOfRequest(details.purpose_of_request);
        setAcademicViewAdditionalInformation(details);
        setAcademicViewRemarks(details.remarks);
        setAcademicViewQuantity(details.quantity);

        if(details.price > 0) {
            $('#academic-view-panel #generate-oop-btn').attr('data-request', details.id);
            setAcademicViewPaymentInformation(details.price);
        } else {
             $('#academic-view-panel #payment-info').addClass('hidden');
        }
    }

    function setAcademicViewID(id) {
        $('#academic-view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setAcademicViewStatusProps(status) {
        switch(status) {
           case 'pending':
                $('#academic-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#academic-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#academic-view-panel #status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#academic-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#academic-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#academic-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#academic-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#academic-view-panel #status').removeClass().addClass('bg-blue-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#academic-view-panel #status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';

        $('#academic-view-panel #status').text(status);             
    }

    function setAcademicViewDocumentRequestedProps(details) {
        let documents = []

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_gradeslip_included) documents.push('Gradeslip');
        if(details.is_ctc_included) documents.push('Certified True Copy');      
        if(details.other_requested_document != "") documents.push(details.other_requested_document);

        $('#academic-view-panel #documents').text(documents.join(' & '));

    }

    function setAcademicViewDateCreated(dt) {
        if(dt != null) $('#academic-view-panel #date-created').text(formatDate(dt));
        else $('#academic-view-panel #date-created').text('-- -- ----');
    }

    function setAcademicViewDateCompleted(dt) {
        if(dt != null) $('#academic-view-panel #date-completed').text(formatDate(dt));
        else $('#academic-view-panel #date-completed').text('-- -- ----');
    }

    function setAcademicViewPurposeOfRequest(purpose) {
        $('#academic-view-panel #purpose').text(purpose);
    }

    function setAcademicViewBeneficiary(details) {
        if(details.is_RA11261_beneficiary == 'yes') {
            $('#academic-view-panel #beneficiary').html(`<a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="hover:underline text-blue-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
        } else {
            $('#academic-view-panel #beneficiary').html('<p class="text-slate-700">No</p>');
            
        }
    }

    function setAcademicViewQuantity(quantity) {
        $('#academic-view-panel #quantity').text(quantity);
    }

    function setAcademicViewPaymentInformation(price) {
        $('#academic-view-panel #payment-info').removeClass('hidden');
        $('#academic-view-panel #price').text(`P ${price}`);
    }

    function setAcademicViewAdditionalInformation(details) {
        $('#academic-view-panel #tor').addClass('hidden');
        $('#academic-view-panel #diploma').addClass('hidden');
        $('#academic-view-panel #gradeslip').addClass('hidden');
        $('#academic-view-panel #ctc').addClass('hidden');
        $('#academic-view-panel #other').addClass('hidden');
        
        if(details.is_tor_included) {
            $('#academic-view-panel #tor').removeClass('hidden');
            $('#academic-view-panel #academic-year').text(details.tor_last_academic_year_attended);
        } 

        if(details.is_diploma_included) {
            $('#academic-view-panel #diploma').removeClass('hidden');
            $('#academic-view-panel #year-graduated').text(details.diploma_year_graduated);
        } 

        if(details.is_gradeslip_included) {
            const year = details.gradeslip_academic_year;
            const sem = formatUnivSemester(details.gradeslip_semester);

            $('#academic-view-panel #gradeslip').removeClass('hidden');
            $('#academic-view-panel #year-sem').text(`S.Y ${year} / ${sem} Sem`);
        } 

        if(details.is_ctc_included) {
            $('#academic-view-panel #ctc').removeClass('hidden');
            $('#academic-view-panel #ctc-document').attr('href', `<?php echo URLROOT;?>${details.ctc_document}`);
            $('#academic-view-panel #ctc-document').text(getFilenameFromPath(details.ctc_document));
        } 
         
        if(details.other_requested_document != "") {
            $('#academic-view-panel #other').removeClass('hidden');
            $('#academic-view-panel #other-document').text(details.other_requested_document);
        }
    }

    function setAcademicViewRemarks(remarks) {
        if(remarks != "") {
            $('#academic-view-panel #remarks').text(remarks);
        } else {
            $('#academic-view-panel #remarks').text('...');
        }
    }

    $('.moral-view-btn').click(function() {
        const id = $(this).attr('data-id');

        const details = ongoing_moral.find(o => o.id == id);

        setMoralViewPanel(details);

        $('#moral-view-panel').removeClass('-right-full').toggleClass('right-0');
    });


    function setMoralViewPanel(details) {
        setMoralViewID(details.id);
        setMoralViewStatusProps(details.status);
        setMoralViewDocumentRequestedProps();
        setMoralViewDateCreated(details.date_created);
        setMoralViewDateCompleted(details.date_completed);
        setMoralViewPurposeOfRequest(details);
        setMoralViewRemarks(details.remarks);
        setMoralViewQuantity(details.quantity);
        
        if(details.price > 0) {
            $('#moral-view-panel #generate-oop-btn').attr('data-request', details.id);
            setMoralViewPaymentInformation(details.price);
        } else {
            $('#moral-view-panel #payment-info').addClass('hidden');
        }
    }

    function setMoralViewID(id) {
        $('#moral-view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setMoralViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#moral-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#moral-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#moral-view-panel #status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#moral-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#moral-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#moral-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#moral-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#moral-view-panel #status').removeClass().addClass('bg-blue-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#moral-view-panel #status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';
        
        $('#moral-view-panel #status').text(status);          
    }

    function setMoralViewDocumentRequestedProps(details) {
        $('#moral-view-panel #documents').text('Good Moral');
    }

    function setMoralViewDateCreated(dt) {
        if(dt != null) $('#moral-view-panel #date-created').text(formatDate(dt));
        else $('#moral-view-panel #date-created').text('-- -- ----');
    }

    function setMoralViewDateCompleted(dt) {
        if(dt != null) $('#moral-view-panel #date-completed').text(formatDate(dt));
        else $('#moral-view-panel #date-completed').text('-- -- ----');
    }

    function setMoralViewPurposeOfRequest(details) {
        if(details.purpose == 'Others') $('#moral-view-panel #purpose').text(details.other_purpose);
        else $('#moral-view-panel #purpose').text(details.purpose);
    }

    function setMoralViewQuantity(quantity) {
        $('#moral-view-panel #quantity').text(quantity || 1);
    }

    function setMoralViewPaymentInformation(price) {
        $('#moral-view-panel #payment-info').removeClass('hidden');
        $('#moral-view-panel #price').text(`P ${price}`);
    }

    function setMoralViewRemarks(remarks) {
        if(remarks != "") {
            $('#moral-view-panel #remarks').text(remarks);
        } else {
            $('#moral-view-panel #remarks').text('...');
        }
    }

    $('.account-view-btn').click(function() {
        const id = $(this).attr('data-id');

        const details = ongoing_account.find(o => o.id == id);

        setAccountViewPanel(details);

        $('#account-view-panel').removeClass('-right-full').toggleClass('right-0');
    });

    function setAccountViewPanel(details) {
        setAccountViewID(details.id);
        setAccountViewStatusProps(details.status);
        setAccountViewDocumentRequestedProps(details);
        setAccountViewDateCreated(details.date_created);
        setAccountViewDateCompleted(details.date_completed);
        setAccountViewPurposeOfRequest(details);
        setAccountViewQuantity(details.quantity);
        setAccountViewRemarks(details.remarks);

        if(details.price > 0) {
            $('#account-view-panel #generate-oop-btn').attr('data-request', details.id);
            setAccountViewPaymentInformation(details.price);
        } else {
            $('#account-view-panel #payment-info').addClass('hidden');
        }
    }

    function setAccountViewID(id) {
        $('#account-view-panel #request-id').text(`( ${formatRequestId(id)} )`);
    }

    function setAccountViewStatusProps(status) {
         switch(status) {
            case 'pending':
                $('#account-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
             case 'awaiting payment confirmation':
                $('#account-view-panel #status').removeClass().addClass('bg-yellow-500 text-white rounded-md px-1 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#account-view-panel #status').removeClass().addClass('bg-cyan-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#account-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#account-view-panel #status').removeClass().addClass('bg-red-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#account-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for payment':
                $('#account-view-panel #status').removeClass().addClass('bg-orange-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#account-view-panel #status').removeClass().addClass('bg-blue-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#account-view-panel #status').removeClass().addClass('bg-green-500 text-white rounded-md px-1 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';
        
        $('#account-view-panel #status').text(status);         
    }

    function setAccountViewDocumentRequestedProps(details) {
        if(details.requested_document == 'soa') {
            $('#account-view-panel #documents').text('Statement of Account');
        } else {
            $('#account-view-panel #documents').text('Order of Payment');
        }
        
    }

    function setAccountViewDateCreated(dt) {
        if(dt != null) $('#account-view-panel #date-created').text(formatDate(dt));
        else $('#account-view-panel #date-created').text('-- -- ----');
    }

    function setAccountViewDateCompleted(dt) {
        if(dt != null) $('#account-view-panel #date-completed').text(formatDate(dt));
        else $('#account-view-panel #date-completed').text('-- -- ----');
    }

    function setAccountViewPurposeOfRequest(details) {
        if(details.purpose == 'Others') $('#account-view-panel #purpose').text(details.other_purpose);
        else $('#account-view-panel #purpose').text(details.purpose);
    }

    function setAccountViewQuantity(quantity) {
        $('#account-view-panel #quantity').text(quantity || 1);
    }

    function setAccountViewPaymentInformation(price) {
        $('#account-view-panel #payment-info').removeClass('hidden');
        $('#account-view-panel #price').text(`P ${price}`);
    }

    function setAccountViewRemarks(remarks) {
        if(remarks != "") {
            $('#account-view-panel #remarks').text(remarks);
        } else {
            $('#account-view-panel #remarks').text('...');
        }
    }

    $('#academic-view-exit-btn').click(function() {
        $('#academic-view-panel').removeClass('right-0').toggleClass('-right-full');
        $('#academic-view-panel #payment-info').addClass('hidden');
    }); 

    $('#moral-view-exit-btn').click(function() {
        $('#moral-view-panel').removeClass('right-0').toggleClass('-right-full');
        $('#moral-view-panel #payment-info').addClass('hidden');
    }); 

    $('#account-view-exit-btn').click(function() {
        $('#account-view-panel').removeClass('right-0').toggleClass('-right-full');
        $('#account-view-panel #payment-info').addClass('hidden');
    }); 
});