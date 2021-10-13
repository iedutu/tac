'use strict';
// Class definition

let KTDatatableDataCargo = function() {
    // Private functions

    let cargo = function() {
        let datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/selectCargoList2.php',
                    },
                },
                pageSize: 10,
                serverPaging: false,
                serverFiltering: false,
                serverSorting: false,
                saveState: {
                    cookie: true,
                    webstorage: true,
                },
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                // height: 450, // datatable's body's fixed height
                footer: false, // display/hide footer
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
                sortable: false,
                width: 20,
                type: 'number',
                selector: {
                    class: ''
                },
                textAlign: 'center',
            }, {
                field: 'client',
                title: 'Client',
            }, {
                field: 'from_city',
                title: 'From city'
            }, {
                field: 'to_city',
                title: 'To city'
            }, {
                field: 'order_type',
                title: 'Order type'
            }, {
                field: 'Status',
                title: 'Status',
                // callback function support for column rendering
                template: function(row) {
                    var status = {
                        0: {
                            'title': 'New',
                            'class': ' label-light-success'
                        },
                        1: {
                            'title': 'Accepted',
                            'class': ' label-light-success'
                        },
                        2: {
                            'title': 'Delivered',
                            'class': ' label-light-danger'
                        },
                        3: {
                            'title': 'Canceled',
                            'class': ' label-light-primary'
                        },
                        4: {
                            'title': 'Success',
                            'class': ' label-light-success'
                        },
                        5: {
                            'title': 'Info',
                            'class': ' label-light-info'
                        },
                        6: {
                            'title': 'Danger',
                            'class': ' label-light-danger'
                        },
                        7: {
                            'title': 'Warning',
                            'class': ' label-light-warning'
                        },
                    };
                    return '<span class="label font-weight-bold label-lg ' + status[row.Status].class + ' label-inline">' + status[row.Status].title + '</span>';
                },
            }],
        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'status');
        });

        $('#kt_datatable_search_from').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'from_city');
        });

        $('#kt_datatable_search_to').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'to_city');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_from, #kt_datatable_search_to').selectpicker();
    };

    return {
        // Public functions
        init: function() {
            cargo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableDataCargo.init();
});
