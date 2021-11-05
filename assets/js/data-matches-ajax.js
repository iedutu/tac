"use strict";
// Class definition

let KTDatatableMatchesList = function() {
    // Private functions

    let matchesList = function() {

        let datatable = $('#kt_datatable_matches_list').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/selectMatchesList.php',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function (raw) {
                            // sample data mapping
                            let dataSet = raw;
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

            extensions: {
                checkbox: false,
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
            columns: [
                {
                    field: 'originator_office',
                    title: 'From',
                    width: 100,
                    template: function (row) {
                        let user_img = 'background-image:url(\'assets/media/svg/flags/' + row.originator_office + '.svg\')';

                        return '<div class="d-flex align-items-center">\
								<div class="symbol symbol-25 flex-shrink-0">\
									<div class="symbol-label" style="' + user_img + '"></div>\
								</div>\
								<div class="ml-2">\
									<div class="text-dark-75 font-weight-bold line-height-sm">' + row.originator_office + '</div>\
									<a href="mailto:'+row.originator_email+'" class="font-size-sm text-dark-50 text-hover-primary">' + row.originator_name + '</a>\
								</div>\
							</div>';
                    },
                }, {
                    field: 'recipient_office',
                    title: 'To',
                    width: 100,
                    template: function (row) {
                        let user_img = 'background-image:url(\'assets/media/svg/flags/' + row.recipient_office + '.svg\')';

                        return '<div class="d-flex align-items-center">\
								<div class="symbol symbol-25 flex-shrink-0">\
									<div class="symbol-label" style="' + user_img + '"></div>\
								</div>\
								<div class="ml-2">\
									<div class="text-dark-75 font-weight-bold line-height-sm">' + row.recipient_office + '</div>\
									<a href="mailto:'+row.recipient_email+'" class="font-size-sm text-dark-50 text-hover-primary">' + row.recipient_name + '</a>\
								</div>\
							</div>';
                    },
                }, {
                    field: 'status',
                    title: 'Status',
                    width: 90,
                    // callback function support for column rendering
                    template: function (row) {
                        let status = {
                            0: {
                                'title': 'Error!',
                                'tooltip': 'This is not supposed to come up.',
                                'class': ' label-light'
                            },
                            1: {
                                'title': 'Available',
                                'tooltip': 'Truck booked for ROUND-TRIP',
                                'class': ' label-secondary'
                            },
                            2: {
                                'title': 'Needed',
                                'tooltip': 'Truck needed for a new order',
                                'class': ' label-danger'
                            },
                            3: {
                                'title': 'Free',
                                'tooltip': 'Truck booked for ONE-WAY',
                                'class': ' label-info'
                            },
                            4: {
                                'title': 'New',
                                'tooltip': 'Truck from the market',
                                'class': ' label-dark'
                            },
                            5: {
                                'title': 'Partial',
                                'tooltip': 'Partially loaded truck',
                                'class': ' label-warning'
                            },
                            6: {
                                'title': 'Solved',
                                'tooltip': 'Fully loaded truck',
                                'class': ' label-success'
                            },
                        };
                        return '<a href="/?page='+row.item_kind+'&id='+row.item_id+'" class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline" data-toggle="tooltip" data-placement="top" title="' + status[row.status].tooltip + '">' + status[row.status].title + '</a>';
                    },
                }, {
                    field: 'availability',
                    title: 'On',
                    width: 85,
                }, {
                    field: 'from_city',
                    title: 'In',
                    width: 75,
                }, {
                    field: 'to_city',
                    title: 'To',
                    width: 75,
                }, {
                    field: 'order_type',
                    title: 'Type',
                    width: 60,
                }, {
                    field: 'loading_meters',
                    title: 'LDM',
                    type: 'number',
                    width: 50,
                    template: function (row) {
                        return row.loading_meters + ' m';
                    },
                }, {
                    field: 'weight',
                    title: 'Weight',
                    type: 'number',
                    width: 60,
                    template: function (row) {
                        return row.weight + ' kg';
                    },
                }, {
                    field: 'volume',
                    title: 'Volume',
                    type: 'number',
                    width: 60,
                    template: function (row) {
                        return row.volume + ' m&sup3';
                    },
                }, {
                    field: 'plate_number',
                    title: 'Truck no',
                    width: 85,
//                    template: function (row) {
//                        return '<b>' + row.plate_number + '</b>';
//                    },
                }, {
                    field: 'ameta',
                    title: 'Ameta',
                    width: 95,
//                    template: function (row) {
//                        return '<b>' + row.ameta + '</b>';
//                    },
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
            matchesList();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableMatchesList.init();
});
