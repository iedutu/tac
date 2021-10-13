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
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
            },

            extensions: {
                checkbox: false,
            },

            // column sorting
            sortable: true,

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
                    sortable: 'asc',
                    width: 50,
                    type: 'number',
                    selector: false,
                    textAlign: 'center',
                    template: function(row) {
                        return '<a href="/?page=cargoInfo&id='+row.id+'">'+row.id+'</a>';
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
									<a href="#" class="font-size-sm text-dark-50 text-hover-primary">' + row.originator_name + '</a>\
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
									<a href="#" class="font-size-sm text-dark-50 text-hover-primary">' + row.recipient_name + '</a>\
								</div>\
							</div>';

                        return output;
                    },
                }, {
                    field: 'order_type',
                    title: 'Order type',
                }, {
                    field: 'client',
                    title: 'Customer',
                }, {
                    field: 'from_city',
                    title: 'Loading from',
                }, {
                    field: 'to_city',
                    title: 'Unloading to',
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
                                'title': 'New',
                                'class': ' label-light-info'
                            },
                            2: {
                                'title': 'Accepted',
                                'class': ' label-light-success'
                            },
                            3: {
                                'title': 'Closed',
                                'class': ' label-light-warning'
                            },
                            4: {
                                'title': 'Cancelled',
                                'class': ' label-light-danger'
                            },
                            5: {
                                'title': 'Expired',
                                'class': ' label-dark'
                            },
                        };
                        return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
                    },
                }],

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

        $('#kt_datatable_search_status, #kt_datatable_search_to, #kt_datatable_search_from').selectpicker();
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
