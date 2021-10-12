"use strict";
// Class definition

let KTDatatableTruckStops = function() {
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
            pageSize: 4,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        extensions: {
            checkbox: true,
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
            field: 'id',
            title: '#',
            sortable: false,
            width: 20,
            selector: {
                class: ''
            },
            textAlign: 'center',
        }, {
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
        }, {
            field: 'weight',
            title: 'Weight',
            type: 'number',
        }, {
            field: 'volume',
            title: 'Volume',
            type: 'number',
        }],
    };

    let cargo_truck_stops = function() {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };

        let datatable = $('#kt_datatable_cargo_truck_stops').KTDatatable(options);

        datatable.on(
            'datatable-on-check datatable-on-uncheck',
            function(e) {
                var checkedNodes = datatable.rows('.datatable-row-active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_records').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            });

        $('#kt_datatable_delete_btn').on('click', function(e) {
            var ids = datatable.rows('.datatable-row-active').
            nodes().
            find('.checkbox > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });

            $('#kt_datatable_group_action_form').collapse('hide');
            console.log(ids);

            let param = [];
            for (var i = 0; i < ids.length; i++) {
                param.push(ids[i]);
            }

            $.ajax({
                url: '/api/deleteStops.php',
                data: {
                    'ids' : param
                },
                type: 'post',
                dataType:'json',
                success: function(output) {
                    datatable.reload();
                },
                error: function(request, status, error) {
                    alert("Error");
                }});



        });

    };

    return {
        // public functions
        init: function() {
            cargo_truck_stops();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableTruckStops.init();
});
