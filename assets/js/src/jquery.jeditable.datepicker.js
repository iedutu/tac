/**
 * Depends on datepicker widget from jQuery-ui
 * https://jqueryui.com/datepicker/
 *
 * @file datepicker plugin for jquery-jeditable
 * @author Nicolas CARPi
 * @copyright © 2008 Mika Tuupola, Nicolas CARPi
 * @home https://github.com/NicolasCARPi/jquery_jeditable
 * @licence MIT (see LICENCE file)
 * @name PluginDatepicker
 * @example <caption>Datepicker example:</caption>
 * $(".date").editable("save.php", {
 *     type      : "datepicker",
 *     submit    : 'OK',
 *     datepicker : {
 *         format: "dd-mm-yy"
 *     },
 *     cancel    : 'cancel',
 * });
 */
'use strict';
(function ($) {
    $.editable.addInputType('datepicker', {

        element : function(settings, original) {
            var input = $('<input />');
            if (settings.datepicker) {
                input.datepicker(settings.datepicker);
            } else {
                input.datepicker();
            }

            // get the date in the correct format

            if (settings.datepicker.format) {
                input.datepicker('option', 'dateFormat', settings.datepicker.format);
            }

            $(this).append(input);
            return(input);
        },

        submit: function (settings, original) {
            var dateRaw = $('input', this).datepicker('getDate');
            var dateFormatted;

            dateFormatted = dateRaw;

            if (settings.datepicker.format) {
                // Code below NOT working
                // dateFormatted = $.datepicker.formatDate(settings.datepicker.format, new Date(dateRaw));

                // Lazy hack to get my date format.
                let _date = new Date(dateRaw);
                dateFormatted =  _date.getDate() + '/' + (_date.getMonth() + 1) + '/' + _date.getFullYear();
            }

            $('input', this).val(dateFormatted);
        },

        plugin : function(settings, original) {
            // prevent disappearing of calendar
            settings.onblur = null;
        }
    });
})(jQuery);
