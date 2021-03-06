// Class definition

let KTBootstrapDatepicker = function () {

    let arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    
    // Private functions
    let _initDatepicker = function () {
        $('#rohel_truck_loading').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows,
            format: "dd-mm-yyyy"
        });

        $('#retour_loading_date').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows,
            format: "dd-mm-yyyy"
        });

        $('#retour_unloading_date').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows,
            format: "dd-mm-yyyy"
        });

        $('#rohel_truck_unloading').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows,
            format: "dd-mm-yyyy"
        });
    }

    return {
        // public functions
        init: function() {
            _initDatepicker(); 
        }
    };
}();

jQuery(document).ready(function() {    
    KTBootstrapDatepicker.init();
});