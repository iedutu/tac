"use strict";
// Class definition

let KTDatatableRemoteAjaxDemo = function() {
    // Private functions

    // basic demo
    let notesData = function() {

        let datatable = $('#kt_datatable_notes').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/selectCargoNotifications.php',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function(raw) {
                            // sample data mapping
                            let dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 5,
                serverPaging: false,
                serverFiltering: false,
                serverSorting: false,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
            },

            // column sorting
            sortable: false,

            pagination: true,

            // columns definition
            columns: [
                {
                    field: 'username',
                    title: 'Author',
                    width: 60,
                    template: function (row) {
                        return '<p class="label-inline" data-toggle="tooltip" data-placement="top" title="' + row.username + '">' + row.name + '</p>';
                    },
                }, {
                    field: 'date',
                    title: 'Date',
                    width: 70
                }, {
                    field: 'comment',
                    title: 'Note'
                }],

        });

        datatable.on('datatable-on-layout-updated', function() {
            KTApp.initTooltips();
        });

    };

    return {
        // public functions
        init: function() {
            notesData();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRemoteAjaxDemo.init();
});
