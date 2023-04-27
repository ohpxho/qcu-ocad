$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 
    const annualConsultationStatusFrequency = <?php echo json_encode($data['annual-consultation-status-frequency']) ?>; 
     const dayRequestStatusFrequency = <?php echo json_encode($data['day-request-status-frequency']) ?>; 
    const history = <?php echo json_encode($data['history']) ?>;

    $(window).load(function() {
        //setActivityGraph('CONSULTATION', new Date().getFullYear());
        checkEveryRowIfHasUnseenMessage();
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

    conn.onmessage = function(msg) {
        msg = JSON.parse(msg.data);

        switch(msg.action) {
            case 'RECEIVE_MESSAGE':
                checkEveryRowIfHasUnseenMessage();
                break;

        }
    };

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

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const statusInFocus = $('#status-filter option:selected').val().toLowerCase();
        const statusInRow = (data[6] || '').toLowerCase();

        const purposeInFocus = $('#purpose-filter option:selected').val().toLowerCase();
        const purposeInRow = (data[4] || '').toLowerCase();
        
        if(
            (statusInFocus == '' && purposeInFocus == '') ||
            (statusInFocus == statusInRow && purposeInFocus == '') || 
            (statusInFocus == '' && purposeInFocus == purposeInRow) ||
            (statusInFocus == statusInRow && purposeInFocus == purposeInRow)
        ) {
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
    
    $('#drop-multiple-row-selection-btn').click(function() {
        const result = confirm("Are you sure? You want to delete these.");
        if(!result) {
            return false;
        }

        $('input[name="request-ids-to-drop"]').val(getRequestIDOfAllRowsSelected().join(','));
        $('#multiple-drop-form').submit();
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

        generateChartForMonthlyConsultationStatusFreq(month, year, data);
        setTableForMonthlyConsultationStatusFreq(month, year, data);
        setMonthlyConsultationHistory(month, year, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function generateChartForMonthlyConsultationStatusFreq(month, year, details) {
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

    function setTableForMonthlyConsultationStatusFreq(month, year, data) {
        $('#freq-table-panel').addClass('hidden');
    }

    function setChartMonthlyStatusFrequencyData(month, year, data) {
        data = data.filter(obj => obj.year == year && obj.month == month);

        const map = new Map();

        for(row of data) {
            map.set(row.day, row);
        }
        
        console.log(map);

        const day_freq = [
            (map.has(1))? map.get(1) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(2))? map.get(2) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(3))? map.get(3) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(4))? map.get(4) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(5))? map.get(5) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(6))? map.get(6) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(7))? map.get(7) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(8))? map.get(8) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(9))? map.get(9) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(10))? map.get(10) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(11))? map.get(11) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(12))? map.get(12) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(13))? map.get(13) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(14))? map.get(14) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(15))? map.get(15) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(16))? map.get(16) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(17))? map.get(17) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(18))? map.get(18) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(19))? map.get(19) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(20))? map.get(20) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(21))? map.get(21) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(22))? map.get(22) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(23))? map.get(23) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(24))? map.get(24) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(25))? map.get(25) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(26))? map.get(26) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(27))? map.get(27) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(28))? map.get(28) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(29))? map.get(29) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(30))? map.get(30) : {resolved: 0, rejected: 0, cancelled: 0},
            (map.has(31))? map.get(31) : {resolved: 0, rejected: 0, cancelled: 0}
        ];

        const limit = getMonthDayLimit(month);
        
        const new_day_freq = day_freq.slice(0, limit);

        const freq = [
            {
              label: "Resolved",
              backgroundColor: '#16A34A',
              borderColor: '#15803D',
              borderWidth: 1,
              data: new_day_freq.map(obj => obj.resolved)
            },
            {
              label: "Declined",
              backgroundColor: '#EA580C',
              borderColor: '#BE123C',
              borderWidth: '#C2410C',
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

    function setMonthlyConsultationHistory(month, year, data) {
        data = data.history.filter(obj => obj.year == year && obj.month == month);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='resolved') status = '<span class="text-green-700">resolved</span>';
            else if(row.status=='unresolved') status = '<span class="text-red-700">cancelled</span>';
            else status = '<span class="text-orange-700">declined</span>'

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.creator_name}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.schedule)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatTime(row.start_time)}</td>
                    <td class="p-2 border border-slate-300 text-center">${getConsultationPurposeValueEquivalent(row.purpose)}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.remarks}</td>    
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
        const data = {annualConsultationStatusFrequency, history};

        $('.report-year').text(year);

        generateChartForAnnualConsultationStatusFreq(year, data);
        setTableForAnnualConsultationStatusFreq(year, data);
        setConsultationHistory(year, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function generateChartForAnnualConsultationStatusFreq(year, details) {
        const statusFreqOfChart = setChartStatusFrequencyData(year, details.annualConsultationStatusFrequency);
        
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

        const jan = data.find(item => item.month == 1) || {resolved: 0, cancelled: 0};
        const feb = data.find(item => item.month == 2) || {resolved: 0, cancelled: 0};
        const mar = data.find(item => item.month == 3) || {resolved: 0, cancelled: 0};
        const apr = data.find(item => item.month == 4) || {resolved: 0, cancelled: 0};
        const may = data.find(item => item.month == 5) || {resolved: 0, cancelled: 0};
        const jun = data.find(item => item.month == 6) || {resolved: 0, cancelled: 0};
        const jul = data.find(item => item.month == 7) || {resolved: 0, cancelled: 0};
        const aug = data.find(item => item.month == 8) || {resolved: 0, cancelled: 0};
        const sep = data.find(item => item.month == 9) || {resolved: 0, cancelled: 0};
        const oct = data.find(item => item.month == 10) || {resolved: 0, cancelled: 0};
        const nov = data.find(item => item.month == 11) || {resolved: 0, cancelled: 0};
        const dec = data.find(item => item.month == 12) || {resolved: 0, cancelled: 0};

        const freq = [
            {
              label: "Resolved",
              backgroundColor: '#16A34A',
              borderColor: '#15803D',
              borderWidth: 1,
              data: [jan.resolved, feb.resolved, mar.resolved, apr.resolved, may.resolved, jun.resolved, jul.resolved, aug.resolved, sep.resolved, oct.resolved, nov.resolved, dec.resolved]
            },
            {
              label: "Declined",
              backgroundColor: '#EA580C',
              borderColor: '#BE123C',
              borderWidth: 1,
              data: [jan.rejected, feb.rejected, mar.rejected, apr.rejected, may.rejected, jun.rejected, jul.rejected, aug.rejected, sep.rejected, oct.rejected, nov.rejected, dec.rejected]
            },
            {
              label: "Cancelled",
              backgroundColor: '#FF1D48',
              borderColor: '#BE123C',
              borderWidth: 1,
              data: [jan.cancelled, feb.cancelled, mar.cancelled, apr.cancelled, may.cancelled, jun.cancelled, jul.cancelled, aug.cancelled, sep.cancelled, oct.cancelled, nov.cancelled, dec.cancelled]
            },
        ];

        return freq;
    }

    function setTableForAnnualConsultationStatusFreq(year, data) {
        data = data.annualConsultationStatusFrequency.filter(obj => obj.year == year);

        const jan = data.find(item => item.month == 1) || {resolved: 0, rejected: 0, cancelled: 0};
        const feb = data.find(item => item.month == 2) || {resolved: 0, rejected: 0, cancelled: 0};
        const mar = data.find(item => item.month == 3) || {resolved: 0, rejected: 0, cancelled: 0};
        const apr = data.find(item => item.month == 4) || {resolved: 0, rejected: 0, cancelled: 0};
        const may = data.find(item => item.month == 5) || {resolved: 0, rejected: 0, cancelled: 0};
        const jun = data.find(item => item.month == 6) || {resolved: 0, rejected: 0, cancelled: 0};
        const jul = data.find(item => item.month == 7) || {resolved: 0, rejected: 0, cancelled: 0};
        const aug = data.find(item => item.month == 8) || {resolved: 0, rejected: 0, cancelled: 0};
        const sep = data.find(item => item.month == 9) || {resolved: 0, rejected: 0, cancelled: 0};
        const oct = data.find(item => item.month == 10) || {resolved: 0, rejected: 0, cancelled: 0};
        const nov = data.find(item => item.month == 11) || {resolved: 0, rejected: 0, cancelled: 0};
        const dec = data.find(item => item.month == 12) || {resolved: 0, rejected: 0, cancelled: 0};

        if(jan.resolved > 0) $('#jan-resolved').text(jan.resolved);
        else $('#jan-resolved').text('-');

        if(jan.rejected > 0) $('#jan-declined').text(jan.rejected);
        else $('#jan-declined').text('-');

        if(jan.cancelled > 0) $('#jan-cancelled').text(jan.cancelled);
        else $('#jan-cancelled').text('-');

        if(feb.resolved > 0) $('#feb-resolved').text(feb.resolved);
        else $('#feb-resolved').text('-');

        if(feb.rejected > 0) $('#feb-declined').text(feb.rejected);
        else $('#feb-declined').text('-');

        if(feb.cancelled > 0) $('#feb-cancelled').text(feb.cancelled);
        else $('#feb-cancelled').text('-');

        if(mar.resolved > 0) $('#mar-resolved').text(mar.resolved);
        else $('#mar-resolved').text('-');

        if(mar.rejected > 0) $('#mar-declined').text(mar.rejected);
        else $('#mar-declined').text('-');

        if(mar.cancelled > 0) $('#mar-cancelled').text(mar.cancelled);
        else $('#mar-cancelled').text('-');

        if(apr.resolved > 0) $('#apr-resolved').text(apr.resolved);
        else $('#apr-resolved').text('-');

        if(apr.rejected > 0) $('#apr-declined').text(apr.rejected);
        else $('#apr-declined').text('-');

        if(apr.cancelled > 0) $('#apr-cancelled').text(apr.cancelled);
        else $('#apr-cancelled').text('-');

        if(may.resolved > 0) $('#may-resolved').text(may.resolved);
        else $('#may-resolved').text('-');

        if(may.rejected > 0) $('#may-declined').text(may.rejected);
        else $('#may-declined').text('-');

        if(may.cancelled > 0) $('#may-cancelled').text(may.cancelled);
        else $('#may-cancelled').text('-');

        if(jun.resolved > 0) $('#jun-resolved').text(jun.resolved);
        else $('#jun-resolved').text('-');

        if(jun.rejected > 0) $('#jun-declined').text(jun.rejected);
        else $('#jun-declined').text('-');

        if(jun.cancelled > 0) $('#jun-cancelled').text(jun.cancelled);
        else $('#jun-cancelled').text('-');

        if(jul.resolved > 0) $('#jul-resolved').text(jul.resolved);
        else $('#jul-resolved').text('-');

        if(jul.rejected > 0) $('#jul-declined').text(jul.rejected);
        else $('#jul-declined').text('-');

        if(jul.cancelled > 0) $('#jul-cancelled').text(jul.cancelled);
        else $('#jul-cancelled').text('-');

        if(aug.resolved > 0) $('#aug-resolved').text(aug.resolved);
        else $('#aug-resolved').text('-');

        if(aug.rejected > 0) $('#aug-declined').text(aug.rejected);
        else $('#aug-declined').text('-');

        if(aug.cancelled > 0) $('#aug-cancelled').text(aug.cancelled);
        else $('#aug-cancelled').text('-');

        if(sep.resolved > 0) $('#sep-resolved').text(sep.resolved);
        else $('#sep-resolved').text('-');

        if(sep.rejected > 0) $('#sep-declined').text(sep.rejected);
        else $('#sep-declined').text('-');

        if(sep.cancelled > 0) $('#sep-cancelled').text(sep.cancelled);
        else $('#sep-cancelled').text('-');

        if(oct.resolved > 0) $('#oct-resolved').text(oct.resolved);
        else $('#oct-resolved').text('-');

        if(oct.rejected > 0) $('#oct-declined').text(oct.rejected);
        else $('#oct-declined').text('-');

        if(oct.cancelled > 0) $('#oct-cancelled').text(oct.cancelled);
        else $('#oct-cancelled').text('-');

        if(nov.resolved > 0) $('#nov-resolved').text(nov.resolved);
        else $('#nov-resolved').text('-');
        
        if(nov.rejected > 0) $('#nov-declined').text(nov.rejected);
        else $('#nov-declined').text('-');

        if(nov.cancelled > 0) $('#nov-cancelled').text(nov.cancelled);
        else $('#nov-cancelled').text('-');

        if(dec.resolved > 0) $('#dec-resolved').text(dec.resolved);
        else $('#dec-resolved').text('-');

        if(dec.rejected > 0) $('#dec-declined').text(dec.rejected);
        else $('#dec-declined').text('-');

        if(dec.cancelled > 0) $('#dec-cancelled').text(dec.cancelled);
        else $('#dec-cancelled').text('-');

        $('#freq-table-panel').removeClass('hidden');
    }

    function setConsultationHistory(year, data) {
        data = data.history.filter(obj => obj.year == year);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='resolved') status = '<span class="text-green-700">resolved</span>';
            else if(row.status=='unresolved') status = '<span class="text-red-700">cancelled</span>';
            else status = '<span class="text-orange-700">declined</span>'

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.creator_name}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.schedule)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatTime(row.start_time)}</td>
                    <td class="p-2 border border-slate-300 text-center">${getConsultationPurposeValueEquivalent(row.purpose)}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.remarks}</td>    
                </tr>
            `);            
        }
    }

    ////////////////////////////////// DAILY //////////////////////////////////////////////////

    function generateDayReport() {
        const date = $('#generate-report #day-report-input input[name="day"]').val();

        const data = {dayRequestStatusFrequency, history};
        
        $('.report-year').text(`(${formatDateToLongDate(date)})`);

        generateChartForDailyConsultationStatusFreq(date, data);
        setTableForDailyConsultationStatusFreq(date, data);
        setDailyConsultationHistory(date, data);

        $('#crystal-report-modal').removeClass('hidden');
        $('#generate-report').addClass('hidden');
    }

    function generateChartForDailyConsultationStatusFreq(date, details) {
        const statusFreqOfChart = setChartDailyStatusFrequencyData(date, details.dayRequestStatusFrequency);

        const data = {
          labels: ['resolved', 'declined', 'cancelled'],
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

        data = data[0] || {'resolved' : 0, 'declined' : 0, 'cancelled' : 0};

        const freq = [
            {
              label: "Status Frequency",
              backgroundColor: ['#16A34A', '#EA580C', '#FF1D48'],
              borderColor: ['#15803D', '#BE123C', '#BE123C'],
              borderWidth: 1,
              data: [data.resolved, data.rejected, data.cancelled]
            }
        ];

        return freq;
    }

    function setTableForDailyConsultationStatusFreq(date, data) {
        $('#freq-table-panel').addClass('hidden');
    }

    function setDailyConsultationHistory(date, data) {
        const dt = new Date(date);
        const day = dt.getDate();
        const year = dt.getFullYear();
        const month = dt.getMonth()+1;

        data = data.history.filter(obj => obj.year == year && obj.month == month && obj.day == day);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='resolved') status = '<span class="text-green-700">resolved</span>';
            else if(row.status=='unresolved') status = '<span class="text-red-700">cancelled</span>';
            else status = '<span class="text-orange-700">declined</span>'

            $('#history-table-body').append(`
                <tr>
                    <td class="p-2 border border-slate-300 text-center">${row.creator_name}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.date_completed)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatDateToLongDate(row.schedule)}</td>
                    <td class="p-2 border border-slate-300 text-center">${formatTime(row.start_time)}</td>
                    <td class="p-2 border border-slate-300 text-center">${getConsultationPurposeValueEquivalent(row.purpose)}</td>
                    <td class="p-2 border border-slate-300 text-center">${status}</td>
                    <td class="p-2 border border-slate-300 text-center">${row.remarks}</td>    
                </tr>
            `);            
        }
    }
});


