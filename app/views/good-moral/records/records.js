$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>;
    const annualRequestStatusFrequency = <?php echo json_encode($data['annual-request-status-frequency']) ?>; 
    const history = <?php echo json_encode($data['history']) ?>;

    $(window).ready(function() {
         setActivityGraph('GOOD_MORAL_DOCUMENT_REQUEST', new Date().getFullYear());
    });

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
        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase() || '';
        const purposeInRow = (data[3] || '').toLowerCase();

        const statusInFocus = $('#status-filter option:selected').val().toLowerCase() || '';
        const statusInRow = (data[4] || '').toLowerCase();
        
        if(
            (purposeInFocus == '' && statusInFocus == '') ||
            (purposeInFocus == purposeInRow && statusInFocus == '') ||
            (purposeInFocus == '' && statusInFocus == statusInRow) ||
            (purposeInFocus == purposeInRow && statusInFocus == statusInRow) 
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

     /**
    * onclick event of status button, display update panel
    **/

    $('.status-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('.edit-btn').click(function() {
        const id = $(this).closest('tr').find('td:first').text();
        requestAndSetupForUpdatePanel(id);
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
        $('#view-panel').removeClass('right-0').addClass('-right-full');
    }); 

    $('#status').click(function() {
        const id = $('#request-id').text();
        requestAndSetupForUpdatePanel(id)
        $('#edit-panel').removeClass('-right-full').toggleClass('right-0');
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

    function setUpdatePanel(details) {
        $('#edit-panel #request-id').text(`(${details.id})`);
        $('#edit-panel select[name="status"]').val(details.status);
        $('#edit-panel textarea[name="remarks"]').val(details.remarks);
        $('#edit-panel input[name="request-id"]').val(details.id);
        $('#edit-panel input[name="student-id"]').val(details.student_id);
    }

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

    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete these.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
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
    
    $('#update-multiple-row-selection-btn').click(function() {
        $('#view-panel').removeClass('right-0').addClass('-right-full');
        $('#update-panel').removeClass('right-0').addClass('-right-full');
        $('#multiple-update-panel').removeClass('-right-full').toggleClass('right-0');
        setMultipleUpdateReqestIDsInput();
        setMultipleUpdateStudentIDsInput();
    });

     /**
    * onclick event of mulltple update exit button, hide multiple update panel
    **/

    $('#multiple-update-exit-btn').click(function() {
        $('#multiple-update-panel').removeClass('right-0').toggleClass('-right-full');
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
        
        if(details.type=='student') setViewStudentInformation(details.student_id);
        else setViewAlumniInformation(details.student_id);
        
        setViewRemarks(details.remarks);
    }

    function setViewID(id) {
        $('#view-panel #request-id').text(`(${id})`);
    }

    function setViewStatusProps(status) {
        switch(status) {
            case 'pending':
                $('#view-panel #status').removeClass().addClass('bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'accepted':
                $('#view-panel #status').removeClass().addClass('bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'rejected':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
             case 'cancelled':
                $('#view-panel #status').removeClass().addClass('bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'in process':
                $('#view-panel #status').removeClass().addClass('bg-orange-100 text-orange-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            case 'accepted':
                $('#view-panel #for claiming').removeClass().addClass('bg-blue-100 text-blue-700 rounded-full px-5 text-sm py-1 cursor-pointer');
                break;
            default:
                $('#view-panel #status').removeClass().addClass('bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 cursor-pointer');
        }

        if(status == 'rejected') status = 'declined';

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
        if(details.purpose == 'Others') $('#view-panel #purpose').text(details.other_purpose);
        else $('#view-panel #purpose').text(details.purpose);
    }

    function setViewStudentInformation(id) {
        $('#student-info').removeClass('hidden');
        $('#alumni-info').addClass('hidden');
        
        const student = getStudentDetails(id);

        student.done(function(result) {
            result = JSON.parse(result);
            $('#stud-name').text(`${result.lname}, ${result.fname} ${result.mname}`);
            $('#stud-course').text(result.course.toUpperCase());
            $('#stud-year').text(formatYearLevel(result.year));
            $('#stud-section').text(result.section);
        });

        student.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
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

    function getStudentDetails(id) {
        return $.ajax({
            url: "/qcu-ocad/student/details",
            type: "POST",
            data: {
                id: id
            }
        });
    }

    function setViewRemarks(remarks) {
        if(remarks != "") {
            $('#view-panel #remarks').text(remarks);
        } else {
            $('#view-panel #remarks').text('...');
        }
    }

    $('#generate-report-modal-btn').click(function() {
        $('#generate-report').removeClass('hidden');
    });

    $('#generate-report-cancel-btn').click(function() {
        $('#generate-report').addClass('hidden');
    });

    $('#generate-report input[type="submit"]').click(function() {
        const year = $('#generate-report input[name="year"]').val();
        const data = {annualRequestStatusFrequency, history};

        $('.report-year').text(year);

        generateChartForAnnualRequestStatusFreq(year, data);
        setTableForAnnualRequestStatusFreq(year, data);
        setRequestHistory(year, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    });

    $('#upload-crystal-report').click(function() {
        const year = $('#generate-report input[name="year"]').val();
        const htmlElement = document.querySelector('#crystal-report');

        html2canvas(htmlElement).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF();
            pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), 0, null, 'FAST');

            pdf.save(`qcu ocad - crystal report ${year}.pdf`);
        });


        $('#crystal-report-modal').addClass('hidden');
        $('#generate-report').addClass('hidden');

        return false;
    });

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

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.student_id}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">Good Moral Certificate</td>
                    <td class="p-2 border border-slate-300 text-center">${row.purpose}</td>
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
            type: "bar",
            data: data,
            options: options
        });
    }

    function setChartStatusFrequencyData(year, data) {
        data = data.filter(obj => obj.year == year);

        const jan = data.find(item => item.month == 1) || {resolved: 0, declined: 0, cancelled: 0};
        const feb = data.find(item => item.month == 2) || {resolved: 0, declined: 0, cancelled: 0};
        const mar = data.find(item => item.month == 3) || {resolved: 0, declined: 0, cancelled: 0};
        const apr = data.find(item => item.month == 4) || {resolved: 0, declined: 0, cancelled: 0};
        const may = data.find(item => item.month == 5) || {resolved: 0, declined: 0, cancelled: 0};
        const jun = data.find(item => item.month == 6) || {resolved: 0, declined: 0, cancelled: 0};
        const jul = data.find(item => item.month == 7) || {resolved: 0, declined: 0, cancelled: 0};
        const aug = data.find(item => item.month == 8) || {resolved: 0, declined: 0, cancelled: 0};
        const sep = data.find(item => item.month == 9) || {resolved: 0, declined: 0, cancelled: 0};
        const oct = data.find(item => item.month == 10) || {resolved: 0, declined: 0, cancelled: 0};
        const nov = data.find(item => item.month == 11) || {resolved: 0, declined: 0, cancelled: 0};
        const dec = data.find(item => item.month == 12) || {resolved: 0, declined: 0, cancelled: 0};

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
});


