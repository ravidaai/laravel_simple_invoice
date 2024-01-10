/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */
var DataTable = function () {

    var initDataTable = function (table, link, columns, order, ajaxFilter, perPage, hasIndex) {
        hasIndex = (typeof hasIndex === "boolean") ? hasIndex : true;

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            'searching': false,
            'lengthChange': false,
            "language": {
                "sProcessing": ".:: Processing ::.",
                "sLengthMenu": "Show _MENU_ entries",
                "sZeroRecords": "No matching records found",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                "sInfoFiltered": "(filtered from _MAX_ total entries)",
                "sInfoPostFix": "",
                "sSearch": "Search:",
                "sUrl": "",
            },
            pagingType: "full_numbers",
            responsive: true,
            "pageLength": perPage,
            "ajax": {
                url: link,
                data: ajaxFilter
            },
            "order": order,
            "columnDefs": [{
                "targets": "_all",
                "defaultContent": ""
            }],
            "columns": columns,
            "fnDrawCallback": function (oSettings) {
                $('.tooltips').tooltip();

                oTable.column(0).nodes().each(function (cell, i) {
                    cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
                });
            }
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        return oTable;
    };

    return {
        init: function (table, link, columns, order, ajaxFilter, perPage, hasIndex) {
            $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: '100px',
                    targets: [5]
                }],
                language: Common.current_language,
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            return initDataTable(table, link, columns, order, ajaxFilter, perPage, hasIndex);
        },
        updateDataTable: function (oTable) {
            oTable.draw(false);
        },
        destroyDataTable: function (oTable) {
            oTable.fnDestroy();
        }
    }
}();