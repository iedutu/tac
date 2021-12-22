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
                beforeTemplate: function (row, data, index) {
                    switch(data.originator_office) {
                        case "Athens": {
                            row.addClass("table-danger");
                            break;
                        }
                        case "Salonic": {
                            row.addClass("table-warning");
                            break;
                        }
                        case "Bucharest": {
                            row.addClass("table-info");
                            break;
                        }
                        case "Deva": {
                            row.addClass("table-active");
                            break;
                        }
                        case "Pucioasa": {
                            row.addClass("table-success");
                            break;
                        }
                    }
                },
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
                    return '<a target=”_blank” href="/?page=truckInfo&id='+row.id+'">'+row.id+'</a>';
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
                field: 'status',
                title: 'Status',
                // callback function support for column rendering
                template: function(row) {
                    var status = {
                        1: {
                            'title': 'Available',
                            'tooltip': 'Round-trip booked truck.',
                            'class': ' label-secondary'
                        },
                        2: {
                            'title': 'Free',
                            'tooltip': 'One-way booked truck.',
                            'class': ' label-info'
                        },
                        3: {
                            'title': 'Market',
                            'tooltip': 'Truck available on the market.',
                            'class': ' label-dark'
                        },
                        4: {
                            'title': 'Partial',
                            'tooltip': 'Partially loaded truck.',
                            'class': ' label-warning'
                        },
                        5: {
                            'title': 'Solved',
                            'tooltip': 'Fully loaded truck.',
                            'class': ' label-success'
                        },
                        6: {
                            'title': 'Cancelled',
                            'tooltip': 'This is not supposed to come up.',
                            'class': ' label-light'
                        },
                    };
                    return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline" data-toggle="tooltip" data-placement="top" title="' + status[row.status].tooltip + '">' + status[row.status].title + '</span>';
                },
            }, {
                field: 'ameta',
                title: 'Ameta',
                width: 75,
            }, {
                field: 'plate_number',
                title: 'License plate',
                width: 150,
            }, {
                field: 'details',
                title: 'Driver details',
            }, {
                field: 'loading_date',
                title: 'Loading date',
                type: 'date',
                width: 75,
                format: 'DD-MM-YYYY',
            }, {
                field: 'unloading_date',
                title: 'Unloading date',
                type: 'date',
                width: 85,
                format: 'DD-MM-YYYY',
            }, {
                field: 'unloading_zone',
                title: 'Unloading zone',
            }, {
                field: 'to_city',
                title: 'Destination',
            }, {
                field: 'contract_type',
                title: 'Contract',
            }, {
                field: 'client',
                title: 'Client',
            }, {
                field: 'retour_loading_from',
                title: 'Retour loading from',
            }, {
                field: 'retour_unloading_from',
                title: 'Retour unloading from',
            }, {
                field: 'retour_loading_date',
                title: 'Retour loading date',
                type: 'date',
                width: 85,
                format: 'DD-MM-YYYY',
            }, {
                field: 'retour_unloading_date',
                title: 'Retour unloading date',
                type: 'date',
                width: 85,
                format: 'DD-MM-YYYY',
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
