$(document).ready( function () {
    const ID = <?php echo json_encode($_SESSION['id']) ?>; 
    const annualConsultationStatusFrequency = <?php echo json_encode($data['annual-consultation-status-frequency']) ?>; 
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
        const statusInRow = (data[5] || '').toLowerCase();

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

    $('#generate-report input[type="submit"]').click(function() {
        const year = $('#generate-report input[name="year"]').val();
        const data = {annualConsultationStatusFrequency, history};

        $('.report-year').text(year);

        generateChartForAnnualConsutationStatusFreq(year, data);
        setTableForAnnualConsultationStatusFreq(year, data);
        setConsultationHistory(year, data);

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

    function setTableForAnnualConsultationStatusFreq(year, data) {
        data = data.annualConsultationStatusFrequency.filter(obj => obj.year == year);

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

        if(jan.resolved > 0) $('#jan-resolved').text(jan.resolved);
        else $('#jan-resolved').text('-');

        if(jan.cancelled > 0) $('#jan-cancelled').text(jan.cancelled);
        else $('#jan-cancelled').text('-');

        if(feb.resolved > 0) $('#feb-resolved').text(feb.resolved);
        else $('#feb-resolved').text('-');

        if(feb.cancelled > 0) $('#feb-cancelled').text(feb.cancelled);
        else $('#feb-cancelled').text('-');

        if(mar.resolved > 0) $('#mar-resolved').text(mar.resolved);
        else $('#mar-resolved').text('-');

        if(mar.cancelled > 0) $('#mar-cancelled').text(mar.cancelled);
        else $('#mar-cancelled').text('-');

        if(apr.resolved > 0) $('#apr-resolved').text(apr.resolved);
        else $('#apr-resolved').text('-');

        if(apr.cancelled > 0) $('#apr-cancelled').text(apr.cancelled);
        else $('#apr-cancelled').text('-');

        if(may.resolved > 0) $('#may-resolved').text(may.resolved);
        else $('#may-resolved').text('-');

        if(may.cancelled > 0) $('#may-cancelled').text(may.cancelled);
        else $('#may-cancelled').text('-');

        if(jun.resolved > 0) $('#jun-resolved').text(jun.resolved);
        else $('#jun-resolved').text('-');

        if(jun.cancelled > 0) $('#jun-cancelled').text(jun.cancelled);
        else $('#jun-cancelled').text('-');

        if(jul.resolved > 0) $('#jul-resolved').text(jul.resolved);
        else $('#jul-resolved').text('-');

        if(jul.cancelled > 0) $('#jul-cancelled').text(jul.cancelled);
        else $('#jul-cancelled').text('-');

        if(aug.resolved > 0) $('#aug-resolved').text(aug.resolved);
        else $('#aug-resolved').text('-');

        if(aug.cancelled > 0) $('#aug-cancelled').text(aug.cancelled);
        else $('#aug-cancelled').text('-');

        if(sep.resolved > 0) $('#sep-resolved').text(sep.resolved);
        else $('#sep-resolved').text('-');

        if(sep.cancelled > 0) $('#sep-cancelled').text(sep.cancelled);
        else $('#sep-cancelled').text('-');

        if(oct.resolved > 0) $('#oct-resolved').text(oct.resolved);
        else $('#oct-resolved').text('-');

        if(oct.cancelled > 0) $('#oct-cancelled').text(oct.cancelled);
        else $('#oct-cancelled').text('-');

        if(nov.resolved > 0) $('#nov-resolved').text(nov.resolved);
        else $('#nov-resolved').text('-');
        
        if(nov.cancelled > 0) $('#nov-cancelled').text(nov.cancelled);
        else $('#nov-cancelled').text('-');

        if(dec.resolved > 0) $('#dec-resolved').text(dec.resolved);
        else $('#dec-resolved').text('-');

        if(dec.cancelled > 0) $('#dec-cancelled').text(dec.cancelled);
        else $('#dec-cancelled').text('-');
    }

    function setConsultationHistory(year, data) {
        data = data.history.filter(obj => obj.year == year);
        
        $('#history-table-body').html('');
        
        for(row of data) {
            let status = '';

            if(row.status=='resolved') status = '<span class="text-green-700">resolved</span>';
            else status = '<span class="text-red-700">cancelled</span>'

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


