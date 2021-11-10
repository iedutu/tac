$(document).ready(function() {
    $('.editable-text').editable('api/updateField.php', {
        indicator      : 'Saving ...',
        type           : 'text',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        tooltip        : 'Click to edit'
    });

    $('.editable-ameta-text').editable('api/updateCargoAmeta.php', {
        indicator      : 'Saving ...',
        type           : 'text',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        tooltip        : 'Click to edit'
    });

    $('.editable-acknowledge-text').editable('api/acknowledgeCargo.php', {
        indicator      : 'Saving ...',
        type           : 'text',
        cssclass       : 'form',
        inputcssclass  : 'form-control',
        tooltip        : 'Click to edit',
        callback : function(result, settings, submitdata) {
            if (result != null) {
                document.getElementById('kt_cargo_status_code').innerHTML = '<span class="label label-lg label-success label-inline mr-2 font-weight-bolder">ACCEPTED</span>';
                document.getElementById('kt_cargo_accepted_by').innerHTML = document.getElementById('kt_operator').value;
                document.getElementById('kt_cargo_accepted_at').innerHTML = document.getElementById('kt_today').value;
                document.getElementById("kt_cargo_accepted_by").classList.add('text-primary');
                document.getElementById("kt_cargo_accepted_at").classList.add('text-primary');
                document.getElementById("plate_number").classList.remove('text-danger');
                document.getElementById("ameta").classList.remove('text-danger');
                document.getElementById("kt_rohel_accept_area").setAttribute('hidden', 'true');
            }
        }
    });

    $('.editable-select-1').editable('api/updateField.php', {
        type           : 'select',
        indicator      : 'Saving ...',
        loadurl        : 'api/cargoDeliveryInstructions.php',
        inputcssclass : 'form-control',
        cssclass       : 'form'
    });

    $('.editable-select-2').editable('api/updateField.php', {
        type           : 'select',
        indicator      : 'Saving ...',
        loadurl        : 'api/cargoOrderType.php',
        inputcssclass : 'form-control',
        cssclass       : 'form'
    });

    $('.editable-select-3').editable('api/updateRecipient.php', {
        type           : 'select',
        indicator      : 'Saving ...',
        loadurl        : 'api/selectUsers.php',
        inputcssclass : 'form-control',
        cssclass       : 'form'
    });

    // There is a bug with Keen, its datepicker and the jeditable package. The only
    // Solution I found was to manually format the date in assets/js/src/jquery.jeditable.datepicker.js
    //
    $(".editable-date").editable("api/updateField.php", {
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
});