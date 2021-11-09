$(document).ready(function() {
    $('.editable-text').editable('api/updateField.php', {
        indicator      : 'Saving ...',
        type           : 'text',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        tooltip        : 'Click to edit ...'
    });

    $('.editable-stop-text').editable('api/updateStop.php', {
        indicator      : 'Saving ...',
        type           : 'text',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        tooltip        : 'Click to edit ...'
    });

    // There is a bug with Keen, its datepicker and the jeditable package. The only
    // Solution I found was to manually format the date in assets/js/src/jquery.jeditable.datepicker.js
    //
    $(".editable-date").editable("api/updateField.php", {
        indicator      : 'Saving ...',
        type           : "datepicker",
        submit         : 'OK',
        cancel         : 'cancel',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        cancelcssclass : 'btn btn-secondary',
        submitcssclass : 'btn btn-primary mr-2',
        datepicker: {
            orientation: "top right",
            todayHighlight: true,
            format: "d-m-yyyy"
        }
    });

    $('.editable-select').editable('api/updateContractType.php', {
        type           : 'select',
        indicator      : 'Saving ...',
        loadurl        : 'api/truckContractType.php',
        inputcssclass : 'form-control',
        cssclass       : 'form',
        callback : function(result, settings, submitdata) {
            if (result != null) {
                console.log(submitdata);
                if(submitdata.value === 'Round-trip') {
                    document.getElementById('kt_truck_status_code').innerHTML = '<span class="label label-lg label-secondary label-inline mr-2 font-weight-bolder" data-toggle="tooltip" data-placement="top" title="Round-trip booked truck">Available truck</span>';
                }
                else {
                    if(submitdata.value === 'One-way') {
                        document.getElementById('kt_truck_status_code').innerHTML = '<span class="label label-lg label-info label-inline mr-2 font-weight-bolder" data-toggle="tooltip" data-placement="top" title="One-way booked truck">Free truck</span>';
                    }
                    else {
                        if(submitdata.value === 'Free-on-market') {
                            document.getElementById('kt_truck_status_code').innerHTML = '<span class="label label-lg label-dark label-inline mr-2 font-weight-bolder" data-toggle="tooltip" data-placement="top" title="Truck available on the market">Free on market</span>';
                        }
                    }
                }
            }
        }
    });

    $('.editable-select-3').editable('api/updateRecipient.php', {
        type           : 'select',
        indicator      : 'Saving ...',
        loadurl        : 'api/selectUsers.php',
        inputcssclass : 'form-control',
        cssclass       : 'form'
    });

});