$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;
    const annualRequestStatusFrequency = <?php echo json_encode($data['annual-request-status-frequency']) ?>; 
    const dayRequestStatusFrequency = <?php echo json_encode($data['day-request-status-frequency']) ?>; 
    const history = <?php echo json_encode($data['history']) ?>;

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
    

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const typeInFocus = $('#type-filter option:selected').val().toLowerCase();
        const typeInRow = (data[5] || '').toLowerCase();

        const docInFocus = $('#document-filter option:selected').val().toLowerCase();
        const docInRow = (data[4] || '').toLowerCase(); 

        if(
            (typeInFocus == '' && docInFocus == '') ||
            (typeInFocus == typeInRow && docInFocus == '') ||
            (typeInFocus == '' && docInFocus == docInRow) ||
            (typeInFocus == typeInRow && docInFocus == docInRow)

        ) return true;

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
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#request-id-btn').click(function() {
        const id = $('#update-request-id').text();
        requestAndSetupForViewPanel(id);
        $('#view-panel').removeClass('-right-full').toggleClass('right-0');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
    
    });

    function requestAndSetupForViewPanel(id) {
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setViewPanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    /**
    * onclick event of status button, display update panel
    **/

    $('.status-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('.update-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#status').click(function() {
        const id = $('#request-id').text();
        requestAndSetupForUpdatePanel(id)
        $('#update-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    });

    function requestAndSetupForUpdatePanel(id) {
        const details = getRequestDetails(id);
        
        details.done(function(result) {
            result = JSON.parse(result);
            setUpdatePanel(result);
        });

        details.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete this.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
    });

    $('#update-multiple-row-selection-btn').click(function() {
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#multiple-update-panel').removeClass('-right-full').toggleClass('right-0');
        setMultipleUpdateReqestIDsInput();
        setMultipleUpdateStudentIDsInput();
    });

    function setMultipleUpdateReqestIDsInput() {
        let ids = getRequestIDOfAllRowsSelected();
        $('input[name="request-ids"]').val(ids.join(','));
    } 

    function setMultipleUpdateStudentIDsInput() {
        let ids = getStudentIDOfAllRowsSelected();
        $('input[name="student-ids"]').val(ids.join(','));
    } 

    function getRequestIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:first').text();
                ids.push(id);
            }
        });

        return ids;        
    }

    function getStudentIDOfAllRowsSelected() {
        let ids = [];
        
        $('.row-checkbox').each(function() {
            if(this.checked) {
                const id = $(this).closest('tr').find('td:eq(1)').text();
                ids.push(id);
            }
        });

        return ids;   
    }

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#view-exit-btn').click(function() {
        $('#view-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    /**
    * onclick event of view exit button, hide view panel
    **/


    $('#update-exit-btn').click(function() {
        $('#update-panel').removeClass('right-0').toggleClass('-right-full');
    }); 

    /**
    * onclick event of mulltple update exit button, hide multiple update panel
    **/

    $('#multiple-update-exit-btn').click(function() {
        $('#multiple-update-panel').removeClass('right-0').toggleClass('-right-full');
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
    * onchange event for select all row checkbox, check all rows
    **/

    $('#select-all-row-checkbox').change(function() {
        if(this.checked) {
            $('.row-checkbox').each(function() {
                $(this).prop('checked', true);
            });
            enableMultipleRowSelectionButtons();
        } else {
            $('.row-checkbox').each(function() {
                $(this).prop('checked', false);
            });
            disableMultipleRowSelectionButtons();
        }
    });

    $('.row-checkbox').change(function() {
        let signal = 0;
        $('.row-checkbox').each(function() {
            if(this.checked) {
                signal = 1;
            } 
        });

        if(signal) enableMultipleRowSelectionButtons();
        else disableMultipleRowSelectionButtons();
    });


    function enableMultipleRowSelectionButtons() {
        $('#update-multiple-row-selection-btn').removeClass('opacity-50 cursor-not-allowed').addClass('cursor-pointer');
        $('#drop-multiple-row-selection-btn').removeClass('opacity-50 cursor-not-allowed').addClass('cursor-pointer');
        $('#update-multiple-row-selection-btn').prop('disabled', false);
        $('#drop-multiple-row-selection-btn').prop('disabled', false);
    }

    function disableMultipleRowSelectionButtons() {
        $('#update-multiple-row-selection-btn').addClass('opacity-50 cursor-not-allowed');
        $('#drop-multiple-row-selection-btn').addClass('opacity-50 cursor-not-allowed');    
        $('#update-multiple-row-selection-btn').prop('disabled', true);
        $('#drop-multiple-row-selection-btn').prop('disabled', true);    
    }

    function getRequestDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/academic_document/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setUpdatePanel(details) {
        $('#update-request-id').text(`(${details.id})`);
        $('select[name="status"]').val(details.status);
        $('textarea[name="remarks"]').val(details.remarks);
        $('input[name="request-id"]').val(details.id);
        $('input[name="student-id"]').val(details.student_id);
    }

    function setViewPanel(details) {
        setViewID(details.id);
        setViewStudentID(details.student_id);
        setViewStatusProps(details.status);
        setViewDocumentRequestedProps(details);
        setViewDateCreated(details.date_created);
        setViewDateCompleted(details.date_completed);
        setViewPurposeOfRequest(details);
        setViewBeneficiary(details);

        if(details.type=='student') setViewStudentInformation(details.student_id);
        else setViewAlumniInformation(details.student_id);
        
        if(details.price > 0) {
            $('#view-panel #generate-oop-btn').attr('data-request', details.id);
            setViewPaymentInformation(details.price);
        }
        
        setViewAdditionalInformation(details);
        setViewRemarks(details.remarks);

    }

    function setViewID(id) {
        $('#request-id').text(`(${id})`);
    }

    function setViewStudentID(id) {
        $('#student-id').text(id);
    }

    function setViewStatusProps(status) {
       switch(status) {
            case 'pending':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 cursor-pointer text-sm py-1');
                break;
            case 'awaiting payment confirmation':
                $('#status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 cursor-pointer text-sm py-1');
                break;
            case 'accepted':
                $('#status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'cancelled':
                $('#status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'for process':
                $('#status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'for claiming':
                $('#status').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 cursor-pointer');
        }

        if(status=='rejected') status='declined';

        $('#status').text(status);         
    }

    function setViewDocumentRequestedProps(details) {
        let documents = []

        if(details.is_tor_included) documents.push('TOR (undergraduate)');
        if(details.is_diploma_included) documents.push('Diploma');
        if(details.is_gradeslip_included) documents.push('Gradeslip');
        if(details.is_ctc_included) documents.push('Certified True Copy');      
        if(details.is_honorable_dismissal_included) documents.push('Honorable Dismissal');      
        if(details.other_requested_document != null && details.other_requested_document != '') documents.push(details.other_requested_document);

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

    function setViewPurposeOfRequest(details) {
        $('#purpose').text(details.purpose_of_request);
    }

    function setViewQuantity(quantity) {
        $('#view-panel #quantity').text(quantity);
    }

    function setViewBeneficiary(details) {
        if(details.is_RA11261_beneficiary == 'yes') {
            $('#beneficiary').html(`<a class="text-sky-700" href="<?php echo URLROOT;?>${details.barangay_certificate}">Barangay Certificate</a> & <a class="text-sky-700" href="<?php echo URLROOT;?>${details.oath_of_undertaking}">Oath Of Undertaking</a>`);
        } else {
            $('#beneficiary').html('<p class="text-slate-700">No</p>');
            
        }
    }

    function setViewStudentInformation(id) {
        $('#student-info').removeClass('hidden');
        $('#alumni-info').addClass('hidden');
        
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#stud-course').text(result.course.toUpperCase());
            $('#stud-year').text(result.year);
            $('#stud-section').text(result.section);
        });

        student.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    }

    function setViewPaymentInformation(price) {
        $('#payment-info').removeClass('hidden');
        $('#price').text(`P ${price}`);
    }

    function setViewAlumniInformation(id) {
        $('#alumni-info').removeClass('hidden');
        $('#student-info').addClass('hidden');
        
        const alumni = getAlumniDetails(id);

        alumni.done(function(result) {
            result = JSON.parse(result);
            $('#alum-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#alum-course').text(result.course.toUpperCase());
            $('#alum-year').text(result.year_graduated);
            $('#alum-section').text(result.section);
        });

        alumni.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
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

        if(details.is_gradeslip_included) {
            const year = details.gradeslip_academic_year;
            const sem = formatUnivSemester(details.gradeslip_semester);

            $('#gradeslip').removeClass('hidden');
            $('#year-sem').text(`S.Y ${year} / ${sem} Sem`);
        } 

        if(details.is_ctc_included) {
            $('#ctc').removeClass('hidden');
            $('#ctc-document').attr('href', `<?php echo URLROOT;?>${details.ctc_document}`);
            $('#ctc-document').text(getFilenameFromPath(details.ctc_document));
        } 
         
        if(details.other_requested_document != null && details.other_requested_document != '') {
            $('#other').removeClass('hidden');
            $('#other-document').text(details.other_requested_document);
        }
    }

    function setViewRemarks(remarks) {
        if(remarks != null) {
            $('#remarks').text(remarks);
        } else {
            $('#remarks').text('...');
        }
    }

    $('#generate-oop-btn').click(function() {
        const id = $(this).data('request');

        const request = getRequestDetails(id);

        request.done(function(result) {
            req = JSON.parse(result);

            let student = '';

            if(req.type == 'student') student = getStudentDetails(req.student_id);
            else student = getAlumniDetails(req.student_id);

            student.done(function(result) {
                stud = JSON.parse(result);

                $('#oop-modal #oop-id').text(stud.id);
                $('#oop-modal #oop-name').text(`${stud.lname} ${stud.fname} ${stud.mname}`);
                $('#oop-modal #oop-price').text(req.price);
                
                let doc = '';

                if(req.is_tor_included) doc = 'TOR (undergraduate)';
                if(req.is_diploma_included) doc = 'Diploma';
                if(req.is_gradeslip_included) doc = 'Gradeslip';
                if(req.is_ctc_included) doc = 'Certified True Copy';      
                if(req.other_requested_document != "") doc = req.other_requested_document;

                $('#oop-modal #oop-doc').text(`${req.quantity} ${doc}`);

                $('#oop-modal').removeClass('hidden');
            });

            student.fail(function(jqXHR, textStatus) {
                alert(result);
            });
        });

        request.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });

        return false
    });

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
    });

     $('#generate-report-modal-btn').click(function() {
        $('#generate-report').removeClass('hidden');
    });

    $('#generate-report-cancel-btn').click(function() {
        $('#generate-report').addClass('hidden');
    }); 

     $('#generate-report input[name="report"]').change(function() {
        const type = $(this).data('type');

        $('#generate-report .report-option').addClass('opacity-50');
        $(this).prev().removeClass('opacity-50');

        switch(type) {
            case 'year':
                displayReportYearOption();
                break;
            case 'month':
                displayReportMonthOption();
                break;
            case 'day':
                displayReportDayOption();
                break;
        }

     });

     function displayReportYearOption() {
        $('#generate-report #year-report-input').removeClass('hidden');
        $('#generate-report #month-report-input').addClass('hidden');
        $('#generate-report #day-report-input').addClass('hidden');
     }

     function displayReportMonthOption() {
        $('#generate-report #year-report-input').addClass('hidden');
        $('#generate-report #month-report-input').removeClass('hidden');
        $('#generate-report #day-report-input').addClass('hidden');
     }

     function displayReportDayOption() {
        $('#generate-report #year-report-input').addClass('hidden');
        $('#generate-report #month-report-input').addClass('hidden');
        $('#generate-report #day-report-input').removeClass('hidden');
     }

    $('#generate-report input[type="submit"]').click(function() {
        const type = $('#generate-report input[name="report"]:checked').data('type');
        
        switch(type) {
            case 'year':
                generateYearReport();
                break;
            case 'month':
                generateMonthlyReport();
                break;
            case 'day':
                generateDayReport();
                break
        }
    });


    $('#upload-crystal-report').click(function() {
        const year = $('#generate-report input[name="year"]').val();
        const htmlElement = document.querySelector('#crystal-report');
        const divHeight = htmlElement.clientHeight;

        html2canvas(htmlElement, {height: divHeight}).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            
            const pdf = new jsPDF();
            
            pdf.addImage(imgData, "PNG", 0, 0, pdf.internal.pageSize.width, canvas.height * pdf.internal.pageSize.width / canvas.width);

            pdf.save(`qcu ocad - crystal report ${year}.pdf`);

            $('#crystal-report-modal').addClass('hidden');
            $('#generate-report').addClass('hidden');
        });

        return false;
    });

    ////////////////////////////////// MONTHLY //////////////////////////////////////////////////

    function generateMonthlyReport() {
        const month = $('#generate-report #month-report-input select[name="month"]').val();
        const year = $('#generate-report #month-report-input input[name="year"]').val();

        const data = {dayRequestStatusFrequency, history};

        $('.report-year').text(`(${getShortWordOfMonth(month)} ${year})`);

        generateChartForMonthlyRequestStatusFreq(month, year, data);
        setTableForMonthlyRequestStatusFreq(month, year, data);
        setMonthlyRequestHistory(month, year, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function generateChartForMonthlyRequestStatusFreq(month, year, details) {
        const statusFreqOfChart = setChartMonthlyStatusFrequencyData(month, year, details.dayRequestStatusFrequency);
        
        const data = {
          labels: getChartLabelForDaysOfMonth(month, year),
          datasets: statusFreqOfChart
        };

        const options = {
            responsive: false,
            animation: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }

        var ctx = document.getElementById("canvas").getContext("2d");

        if(window.chart != null) {
            window.chart.destroy();
        }

        window.chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    }

    function setTableForMonthlyRequestStatusFreq(month, year, data) {
        $('#freq-table-panel').addClass('hidden');
    }

    function setChartMonthlyStatusFrequencyData(month, year, data) {
        data = data.filter(obj => obj.year == year && obj.month == month);

        const map = new Map();

        for(row of data) {
            map.set(row.day, row);
        }

        const day_freq = [
            (map.has(1))? map.get(1) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(2))? map.get(2) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(3))? map.get(3) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(4))? map.get(4) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(5))? map.get(5) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(6))? map.get(6) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(7))? map.get(7) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(8))? map.get(8) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(9))? map.get(9) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(10))? map.get(10) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(11))? map.get(11) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(12))? map.get(12) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(13))? map.get(13) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(14))? map.get(14) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(15))? map.get(15) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(16))? map.get(16) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(17))? map.get(17) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(18))? map.get(18) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(19))? map.get(19) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(20))? map.get(20) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(21))? map.get(21) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(22))? map.get(22) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(23))? map.get(23) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(24))? map.get(24) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(25))? map.get(25) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(26))? map.get(26) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(27))? map.get(27) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(28))? map.get(28) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(29))? map.get(29) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(30))? map.get(30) : {completed: 0, declined: 0, cancelled: 0},
            (map.has(31))? map.get(31) : {completed: 0, declined: 0, cancelled: 0}
        ];

        const limit = getMonthDayLimit(month);
        
        const new_day_freq = day_freq.slice(0, limit);

        const freq = [
            {
              label: "Completed",
              backgroundColor: '#16A34A',
              borderColor: '#15803D',
              borderWidth: 1,
              data: new_day_freq.map(obj => obj.completed)
            },
            {
              label: "Declined",
              backgroundColor: '#EA580C',
              borderColor: '#BE123C',
              borderWidth: 1,
              data: new_day_freq.map(obj => obj.rejected)
            },
            {
              label: "Cancelled",
              backgroundColor: '#FF1D48',
              borderColor: '#BE123C',
              borderWidth: 1,
              data:new_day_freq.map(obj => obj.cancelled)
            }

        ];

        return freq;

    }

    function setMonthlyRequestHistory(month, year, data) {
        data = data.history.filter(obj => obj.year == year && obj.month == month);

        $('#history-table-body').html('');

        for(row of data) {
            let status = '';

            if(row.status=='completed') status = '<span class="text-green-700">completed</span>';
            else if(row.status == 'cancelled') status = `<span class="text-red-700">cancelled</span>`;
            else `<span class="text-orange-700">declined</span>`

            const remark = row.remarks || '';

           let doc = ''

            if(row.is_tor_included) doc = 'TOR (undergraduate)';
            if(row.is_diploma_included) doc = 'Diploma';
            if(row.is_gradeslip_included) doc = 'Gradeslip';
            if(row.is_ctc_included) doc = 'Certified True Copy';      
            if(row.is_honorable_dismissal_included) doc = 'Honorable Dismissal';      
            if(row.other_requested_document != null && row.other_requested_document != '') doc = row.other_requested_document;

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.student_id}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${doc}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.purpose_of_request}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${remark}</td>    
                </tr>
            `);            
        }
    }

    function getChartLabelForDaysOfMonth(month, year) {
        month = parseInt(month);

        switch(month) {
            case 1:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]; 
            case 2:
                if(year%4==0) return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29];
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28]
            case 3:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
            case 4:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 30];
            case 5: 
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
            case 6:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
            case 7:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
            case 8:
                return[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
            case 9:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]; 
            case 10:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];  
            case 11:
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
            case 12: 
                return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
        }
    }

    ////////////////////////////////// YEARLY //////////////////////////////////////////////////

    function generateYearReport() {
        const year = $('#generate-report #year-report-input input[name="year"]').val();
        const data = {annualRequestStatusFrequency, history};

        $('.report-year').text(year);

        generateChartForAnnualRequestStatusFreq(year, data);
        setTableForAnnualRequestStatusFreq(year, data);
        setRequestHistory(year, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function setTableForAnnualRequestStatusFreq(year, data) {
        data = data.annualRequestStatusFrequency.filter(obj => obj.year == year);
        
        const jan = data.find(item => item.month == 1) || {completed: 0, declined: 0, cancelled: 0};
        const feb = data.find(item => item.month == 2) || {completed: 0, declined: 0, cancelled: 0};
        const mar = data.find(item => item.month == 3) || {completed: 0, declined: 0, cancelled: 0};
        const apr = data.find(item => item.month == 4) || {completed: 0, declined: 0, cancelled: 0};
        const may = data.find(item => item.month == 5) || {completed: 0, declined: 0, cancelled: 0};
        const jun = data.find(item => item.month == 6) || {completed: 0, declined: 0, cancelled: 0};
        const jul = data.find(item => item.month == 7) || {completed: 0, declined: 0, cancelled: 0};
        const aug = data.find(item => item.month == 8) || {completed: 0, declined: 0, cancelled: 0};
        const sep = data.find(item => item.month == 9) || {completed: 0, declined: 0, cancelled: 0};
        const oct = data.find(item => item.month == 10) || {completed: 0, declined: 0, cancelled: 0};
        const nov = data.find(item => item.month == 11) || {completed: 0, declined: 0, cancelled: 0};
        const dec = data.find(item => item.month == 12) || {completed: 0, declined: 0, cancelled: 0};

        //jan
        if(jan.completed > 0) $('#jan-completed').text(jan.completed);
        else $('#jan-completed').text('-');

        if(jan.cancelled > 0) $('#jan-cancelled').text(jan.cancelled);
        else $('#jan-cancelled').text('-');

        if(jan.declined > 0) $('#jan-declined').text(jan.declined);
        else $('#jan-declined').text('-');

        //feb
        if(feb.completed > 0) $('#feb-completed').text(feb.completed);
        else $('#feb-completed').text('-');

        if(feb.cancelled > 0) $('#feb-cancelled').text(feb.cancelled);
        else $('#feb-cancelled').text('-');

        if(feb.declined > 0) $('#feb-declined').text(feb.declined);
        else $('#feb-declined').text('-');

        //mar
        if(mar.completed > 0) $('#mar-completed').text(mar.completed);
        else $('#mar-completed').text('-');

        if(mar.cancelled > 0) $('#mar-cancelled').text(mar.cancelled);
        else $('#mar-cancelled').text('-');

        if(mar.declined > 0) $('#mar-declined').text(mar.declined);
        else $('#mar-declined').text('-');

        //apr
        if(apr.completed > 0) $('#apr-completed').text(apr.completed);
        else $('#apr-completed').text('-');

        if(apr.cancelled > 0) $('#apr-cancelled').text(apr.cancelled);
        else $('#apr-cancelled').text('-');

        if(apr.declined > 0) $('#apr-declined').text(apr.declined);
        else $('#apr-declined').text('-');

        //may
        if(may.completed > 0) $('#may-completed').text(may.completed);
        else $('#may-completed').text('-');

        if(may.cancelled > 0) $('#may-cancelled').text(may.cancelled);
        else $('#may-cancelled').text('-');

        if(may.declined > 0) $('#may-declined').text(may.declined);
        else $('#may-declined').text('-');

        //june
        if(jun.completed > 0) $('#jun-completed').text(jun.completed);
        else $('#jun-completed').text('-');

        if(jun.cancelled > 0) $('#jun-cancelled').text(jun.cancelled);
        else $('#jun-cancelled').text('-');

        if(jun.declined > 0) $('#jun-declined').text(jun.declined);
        else $('#jun-declined').text('-');

        //jul
        if(jul.completed > 0) $('#jul-completed').text(jul.completed);
        else $('#jul-completed').text('-');

        if(jul.cancelled > 0) $('#jul-cancelled').text(jul.cancelled);
        else $('#jul-cancelled').text('-');

        if(jul.declined > 0) $('#jul-declined').text(jul.declined);
        else $('#jul-declined').text('-');

        //aug
        if(aug.completed > 0) $('#aug-completed').text(aug.completed);
        else $('#aug-completed').text('-');

        if(aug.cancelled > 0) $('#aug-cancelled').text(aug.cancelled);
        else $('#aug-cancelled').text('-');

        if(aug.declined > 0) $('#aug-declined').text(aug.declined);
        else $('#aug-declined').text('-');

        //sep
        if(sep.completed > 0) $('#sep-completed').text(sep.completed);
        else $('#sep-completed').text('-');

        if(sep.cancelled > 0) $('#sep-cancelled').text(sep.cancelled);
        else $('#sep-cancelled').text('-');

        if(sep.declined > 0) $('#sep-declined').text(sep.declined);
        else $('#sep-declined').text('-');

        //oct
        if(oct.completed > 0) $('#oct-completed').text(oct.completed);
        else $('#oct-completed').text('-');

        if(oct.cancelled > 0) $('#oct-cancelled').text(oct.cancelled);
        else $('#oct-cancelled').text('-');

        if(oct.declined > 0) $('#oct-declined').text(oct.declined);
        else $('#oct-declined').text('-');

        //nov
        if(nov.completed > 0) $('#nov-completed').text(nov.completed);
        else $('#nov-completed').text('-');
        
        if(nov.cancelled > 0) $('#nov-cancelled').text(nov.cancelled);
        else $('#nov-cancelled').text('-');

        if(nov.declined > 0) $('#nov-declined').text(nov.declined);
        else $('#nov-declined').text('-');

        //dec
        if(dec.completed > 0) $('#dec-completed').text(dec.completed);
        else $('#dec-completed').text('-');

        if(dec.cancelled > 0) $('#dec-cancelled').text(dec.cancelled);
        else $('#dec-cancelled').text('-');

        if(dec.declined > 0) $('#dec-declined').text(dec.declined);
        else $('#dec-declined').text('-');

        $('#freq-table-panel').removeClass('hidden');
    }

    function setRequestHistory(year, data) {
        data = data.history.filter(obj => obj.year == year);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='completed') status = '<span class="text-green-700">completed</span>';
            else if(row.status == 'cancelled') status = `<span class="text-red-700">cancelled</span>`;
            else `<span class="text-orange-700">declined</span>`

            const remark = row.remarks || '';

            let doc = ''

            if(row.is_tor_included) doc = 'TOR (undergraduate)';
            if(row.is_diploma_included) doc = 'Diploma';
            if(row.is_gradeslip_included) doc = 'Gradeslip';
            if(row.is_ctc_included) doc = 'Certified True Copy';      
            if(row.is_honorable_dismissal_included) doc = 'Honorable Dismissal';      
            if(row.other_requested_document != null && row.other_requested_document != '') doc = row.other_requested_document;

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.student_id}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${doc}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.purpose_of_request}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${remark}</td>    
                </tr>
            `);            
        }
    }

    function generateChartForAnnualRequestStatusFreq(year, details) {
        const statusFreqOfChart = setChartStatusFrequencyData(year, details.annualRequestStatusFrequency);
        
        const data = {
          labels: ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: statusFreqOfChart
        };

        const options = {
            responsive: false,
            animation: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }

        var ctx = document.getElementById("canvas").getContext("2d");

        if(window.chart != null) {
            window.chart.destroy();
        }

        window.chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    }

    function setChartStatusFrequencyData(year, data) {
        data = data.filter(obj => obj.year == year);

        const jan = data.find(item => item.month == 1) || {completed: 0, declined: 0, cancelled: 0};
        const feb = data.find(item => item.month == 2) || {completed: 0, declined: 0, cancelled: 0};
        const mar = data.find(item => item.month == 3) || {completed: 0, declined: 0, cancelled: 0};
        const apr = data.find(item => item.month == 4) || {completed: 0, declined: 0, cancelled: 0};
        const may = data.find(item => item.month == 5) || {completed: 0, declined: 0, cancelled: 0};
        const jun = data.find(item => item.month == 6) || {completed: 0, declined: 0, cancelled: 0};
        const jul = data.find(item => item.month == 7) || {completed: 0, declined: 0, cancelled: 0};
        const aug = data.find(item => item.month == 8) || {completed: 0, declined: 0, cancelled: 0};
        const sep = data.find(item => item.month == 9) || {completed: 0, declined: 0, cancelled: 0};
        const oct = data.find(item => item.month == 10) || {completed: 0, declined: 0, cancelled: 0};
        const nov = data.find(item => item.month == 11) || {completed: 0, declined: 0, cancelled: 0};
        const dec = data.find(item => item.month == 12) || {completed: 0, declined: 0, cancelled: 0};

        const freq = [
            {
              label: "Completed",
              backgroundColor: '#16A34A',
              borderColor: '#15803D',
              borderWidth: 1,
              data: [jan.completed, feb.completed, mar.completed, apr.completed, may.completed, jun.completed, jul.completed, aug.completed, sep.completed, oct.completed, nov.completed, dec.completed]
            },
            {
              label: "Declined",
              backgroundColor: '#EA580C',
              borderColor: '#BE123C',
              borderWidth: '#C2410C',
              data: [jan.declined, feb.declined, mar.declined, apr.declined, may.declined, jun.declined, jul.declined, aug.declined, sep.declined, oct.declined, nov.declined, dec.declined]
            },
            {
              label: "Cancelled",
              backgroundColor: '#FF1D48',
              borderColor: '#BE123C',
              borderWidth: 1,
              data: [jan.cancelled, feb.cancelled, mar.cancelled, apr.cancelled, may.cancelled, jun.cancelled, jul.cancelled, aug.cancelled, sep.cancelled, oct.cancelled, nov.cancelled, dec.cancelled]
            }

        ];

        return freq;
    }

    ////////////////////////////////// DAILY //////////////////////////////////////////////////

    function generateDayReport() {
        const date = $('#generate-report #day-report-input input[name="day"]').val();

        const data = {dayRequestStatusFrequency, history};

        console.log(data);
        
        $('.report-year').text(`(${formatDateToLongDate(date)})`);

        generateChartForDailyRequestStatusFreq(date, data);
        setTableForDailyRequestStatusFreq(date, data);
        setDailyRequestHistory(date, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function generateChartForDailyRequestStatusFreq(date, details) {
        const statusFreqOfChart = setChartDailyStatusFrequencyData(date, details.dayRequestStatusFrequency);

        const data = {
          labels: ['completed', 'declined', 'cancelled'],
          datasets: statusFreqOfChart
        };

        const options = {
            responsive: false,
            animation: false,
            plugins: {
                responsive: true,
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }

        var ctx = document.getElementById("canvas").getContext("2d");

        if(window.chart != null) {
            window.chart.destroy();
        }

        window.chart = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });

    }

    function setChartDailyStatusFrequencyData(date, data) {
        const dt = new Date(date);
        const day = dt.getDate();
        const year = dt.getFullYear();
        const month = dt.getMonth()+1;

        data = data.filter(obj => obj.year == year && obj.month == month && obj.day == day);
        
        data = data[0] || {'completed' : 0, 'declined' : 0, 'cancelled' : 0};

        const freq = [
            {
              label: "Status Frequency",
              backgroundColor: ['#16A34A', '#EA580C', '#FF1D48'],
              borderColor: ['#15803D', '#BE123C', '#BE123C'],
              borderWidth: 1,
              data: [data.completed, data.declined, data.cancelled]
            }
        ];

        return freq;
    }

    function setTableForDailyRequestStatusFreq(date, data) {
        $('#freq-table-panel').addClass('hidden');
    }

    function setDailyRequestHistory(date, data) {
        const dt = new Date(date);
        const day = dt.getDate();
        const year = dt.getFullYear();
        const month = dt.getMonth()+1;

        data = data.history.filter(obj => obj.year == year && obj.month == month && obj.day == day);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='completed') status = '<span class="text-green-700">completed</span>';
            else if(row.status == 'cancelled') status = `<span class="text-red-700">cancelled</span>`;
            else `<span class="text-orange-700">declined</span>`

            const remark = row.remarks || '';

            let doc = ''

            if(row.is_tor_included) doc = 'TOR (undergraduate)';
            if(row.is_diploma_included) doc = 'Diploma';
            if(row.is_gradeslip_included) doc = 'Gradeslip';
            if(row.is_ctc_included) doc = 'Certified True Copy';      
            if(row.is_honorable_dismissal_included) doc = 'Honorable Dismissal';      
            if(row.other_requested_document != null && row.other_requested_document != '') doc = row.other_requested_document;

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.student_id}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${doc}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.purpose_of_request}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${remark}</td>    
                </tr>
            `);            
        }
    }
});


