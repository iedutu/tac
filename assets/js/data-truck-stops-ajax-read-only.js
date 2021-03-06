"use strict";
// Class definition

let KTDatatableTruckStopsReadOnly = function() {
    // Private functions

    let options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/api/selectTruckStops.php',
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
        sortable: false,

        pagination: true,

        // columns definition
        columns: [{
            field: 'stop_id',
            title: 'Stop #',
            template: function(row) {
                return parseInt(row.stop_id)+1;
            },
        }, {
            field: 'city',
            title: 'City',
        }, {
            field: 'cmr',
            title: 'CMRs',
            type: 'number',
        }, {
            field: 'loading_meters',
            title: 'LDM',
            type: 'number',
            template: function (row) {
                return row.loading_meters + ' m';
            },
        }, {
            field: 'weight',
            title: 'Weight',
            type: 'number',
            template: function (row) {
                return row.weight + ' kg';
            },
        }, {
            field: 'volume',
            title: 'Volume',
            type: 'number',
            template: function (row) {
                return row.volume + ' m&sup3';
            },
        }],
    };

    let cargo_truck_stops_read_only = function() {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };

        let datatable = $('#kt_datatable_cargo_truck_stops_read_only').KTDatatable(options);

        datatable.on('datatable-on-layout-updated', function() {
            KTApp.initTooltips();
        });
    };

    return {
        // public functions
        init: function() {
            cargo_truck_stops_read_only();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableTruckStopsReadOnly.init();
});
