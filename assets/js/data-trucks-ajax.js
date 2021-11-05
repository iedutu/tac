"use strict";
// Class definition

var KTDatatableTruckList = function() {
    // Private functions

    var truckDatatable = function() {

        var datatable = $('#kt_datatable_truck_list').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/selectTruckList.php',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                saveState: false
            },

            // layout definition
            layout: {
                // allows horizontal scrolling
                scroll: true,
                footer: false,
            },

            // column sorting
            sortable: true,

            pagination: true,

            // allows horizontal scrolling
            rows: {
                autoHide: false,
            },

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [{
                field: 'id',
                title: '#',
                width: 50,
                type: 'number',
                sortable: 'desc',
                selector: false,
                textAlign: 'center',
                template: function(row) {
                    return '<a href="/?page=truckInfo&id='+row.id+'">'+row.id+'</a>';
                },
            }, {
                field: 'originator_office',
                title: 'From',
                width: 120,
                template: function(row) {
                    var user_img = 'background-image:url(\'assets/media/svg/flags/' + row.originator_office + '.svg\')';

                    var output = '';
                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-25 flex-shrink-0">\
									<div class="symbol-label" style="' + user_img + '"></div>\
								</div>\
								<div class="ml-2">\
									<div class="text-dark-75 font-weight-bold line-height-sm">' + row.originator_office + '</div>\
									<a href="mailto:'+row.originator_email+'" class="font-size-sm text-dark-50 text-hover-primary">' + row.originator_name + '</a>\
								</div>\
							</div>';

                    return output;
                },
            }, {
                field: 'recipient_office',
                title: 'To',
                template: function(row) {
                    var user_img = 'background-image:url(\'assets/media/svg/flags/' + row.recipient_office + '.svg\')';

                    var output = '';
                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-25 flex-shrink-0">\
									<div class="symbol-label" style="' + user_img + '"></div>\
								</div>\
								<div class="ml-2">\
									<div class="text-dark-75 font-weight-bold line-height-sm">' + row.recipient_office + '</div>\
									<a href="mailto:'+row.recipient_email+'" class="font-size-sm text-dark-50 text-hover-primary">' + row.recipient_name + '</a>\
								</div>\
							</div>';

                    return output;
                },
            }, {
                field: 'from_city',
                title: 'Departure from',
            }, {
                field: 'to_city',
                title: 'Destination',
            }, {
                field: 'loading_date',
                title: 'Loading date',
                type: 'date',
                format: 'DD-MM-YYYY',
            }, {
                field: 'unloading_date',
                title: 'Unloading date',
                type: 'date',
                format: 'DD-MM-YYYY',
            }, {
                field: 'plate_number',
                title: 'License plate',
            }, {
                field: 'ameta',
                title: 'Ameta',
            }, {
                field: 'status',
                title: 'Status',
                // callback function support for column rendering
                template: function(row) {
                    var status = {
                        1: {
                            'title': 'Available',
                            'class': ' label-light-info'
                        },
                        2: {
                            'title': 'Free',
                            'class': ' label-light'
                        },
                        3: {
                            'title': 'New',
                            'class': ' label-light'
                        },
                        4: {
                            'title': 'Partial',
                            'class': ' label-light-warning'
                        },
                        5: {
                            'title': 'Solved',
                            'class': ' label-light-primary'
                        },
                        6: {
                            'title': 'Cancelled',
                            'class': ' label-light-danger'
                        },
                    };
                    return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
                },
            }],

        });

        datatable.on('datatable-on-layout-updated', function() {
            KTApp.initTooltips();
        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val(), 'status');
        });

        $('#kt_datatable_search_to').on('change', function() {
            datatable.search($(this).val(), 'recipient_office');
        });

        $('#kt_datatable_search_from').on('change', function() {
            datatable.search($(this).val(), 'originator_office');
        });

        $('#kt_datatable_search_country_to').on('change', function() {
            datatable.search($(this).val(), 'recipient_country');
        });

        $('#kt_datatable_search_country_from').on('change', function() {
            datatable.search($(this).val(), 'originator_country');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_to, #kt_datatable_search_from, #kt_datatable_search_country_to, #kt_datatable_search_country_from').selectpicker();
    };

    return {
        // public functions
        init: function() {
            truckDatatable();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableTruckList.init();
});
