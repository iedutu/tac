"use strict";
// Class definition

var KTDatatableRemoteAjaxDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {

        var datatable = $('#kt_datatable').KTDatatable({
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
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [{
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 50,
                type: 'number',
                selector: false,
                textAlign: 'center',
                template: function(row) {
                    return '<a href="/?page=truckInfo&id='+row.id+'">'+row.id+'</a>';
                },
            }, {
                field: 'originator',
                title: 'From',
            }, {
                field: 'recipient',
                title: 'To',
            }, {
                field: 'from_city',
                title: 'Available in',
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
                field: 'status',
                title: 'Status',
                // callback function support for column rendering
                template: function(row) {
                    var status = {
                        0: {
                            'title': 'New',
                            'class': ' label-light-info'
                        },
                        1: {
                            'title': 'Accepted',
                            'class': ' label-light-success'
                        },
                        2: {
                            'title': 'Expired',
                            'class': ' label-light-danger'
                        },
                    };
                    return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
                },
            }],

        });

		$('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRemoteAjaxDemo.init();
});
