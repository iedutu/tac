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
});