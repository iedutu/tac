"use strict";
// Class definition

var KTDatatableCargoList = function() {
    // Private functions

    var cargoList = function() {

        var datatable = $('#kt_datatable_cargo_list').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/selectCargoList.php',
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

            extensions: {
                checkbox: false,
            },

            // column sorting
            sortable: true,

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

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '#',
                    width: 50,
                    type: 'number',
                    selector: false,
                    sortable: 'desc',
                    textAlign: 'center',
                    template: function(row) {
                        return '<a target=”_blank” href="/?page=cargoInfo&id='+row.id+'">'+row.id+'</a>';
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
                    width: 95,
                    title: 'Status',
                    // callback function support for column rendering
                    template: function(row) {
                        var status = {
                            1: {
                                'title': 'New',
                                'tooltip': 'New cargo.',
                                'class': ' label-danger'
                            },
                            2: {
                                'title': 'Accepted',
                                'tooltip': 'Accepted cargo.',
                                'class': ' label-success'
                            },
                            3: {
                                'title': 'Solved',
                                'tooltip': 'Closed cargo.',
                                'class': ' label-success'
                            },
                            4: {
                                'title': 'Cancelled',
                                'tooltip': 'Cancelled cargo.',
                                'class': ' label-light'
                            },
                            5: {
                                'title': 'Expired',
                                'tooltip': 'Expired cargo.',
                                'class': ' label-light'
                            },
                        };
                        return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline" data-toggle="tooltip" data-placement="top" title="' + status[row.status].tooltip + '">' + status[row.status].title + '</span>';
                    },
                }, {
                    field: 'order_type',
                    title: 'Order type',
                }, {
                    field: 'client',
                    title: 'Customer',
                }, {
                    field: 'shipper',
                    title: 'Shipper',
                    template: function(row) {
                        if((row.shipper === null) || (row.shipper === '')){
                            return 'N/A';
                        }
                        return row.shipper;
                    },
                }, {
                    field: 'from_city',
                    title: 'Loading from',
                }, {
                    field: 'to_city',
                    title: 'Unloading to',
                }, {
                    field: 'plate_number',
                    title: 'License plate',
                    template: function(row) {
                        if(row.plate_number === null) {
                            return 'N/A';
                        }
                        return row.plate_number;
                    },
                }, {
                    field: 'ameta',
                    width: 60,
                    title: 'Ameta',
                    template: function(row) {
                        if(row.ameta === null) {
                            return 'N/A';
                        }
                        return row.ameta;
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
            cargoList();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableCargoList.init();
});
