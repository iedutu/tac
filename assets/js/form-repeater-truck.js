// Class definition
let KTFormRepeater = function() {

    // Private functions
    let new_truck = function() {
        $('#kt_repeater_truck').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }

    return {
        // public functions
        init: function() {
            new_truck();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormRepeater.init();
});