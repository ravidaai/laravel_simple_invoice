/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */

var Suppliers = function () {

    var view_tbl;
    var view_url = suppliers_view;
    var list_url = suppliers_list;
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "name", "orderable": true, "searchable": true},
            {"data": "display_name", "orderable": true, "searchable": true},
            {"data": "email", "orderable": true, "searchable": true},
            {"data": "mobile", "orderable": true, "searchable": true},
            {"data": "country_id", "orderable": true, "searchable": true},
            {"data": "created_at", "orderable": true, "searchable": true},
            {"data": "status", "orderable": false, "searchable": false},
            {"data": "actions", "orderable": false, "searchable": false}
        ];
        var perPage = 25;
        var order = [[2, 'desc']];

        var ajaxFilter = function (d) {
            d.name = $('#name').val();
            d.display_name = $('#display_name').val();
            d.email = $('#email').val();
        };

        view_tbl = DataTable.init($('#suppliers_table'), link, columns, order, ajaxFilter, perPage);
    };
    /////////////////// ADD ///////////////////
    ///////////////////////////////////////////
    var add = function () {
        $('#frmAddSupplier').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, addCallBack);
        });
    };

    var addCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = view_url;
            }, delay);
        }
    };
    //////// ADD Supplier From Invoice /////////
    ///////////////////////////////////////////
    var addSupplierFromInvoice = function () {
        $('#frmAddSupplierFromInvoice').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, addSupplierFromInvoiceCallBack);
        });
    };

    var addSupplierFromInvoiceCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                $('#addNewSupplierModal').modal('hide');
                $("#supplier_id").append(new Option(obj.data.name, obj.data.id));
                $('#supplier_id').selectpicker('refresh');
            }, delay);
        }
    };
    /////////////////// Edit //////////////////
    ///////////////////////////////////////////
    var edit = function () {
        $('#frmEditSupplier').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, editCallBack);
        });
    };

    var editCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = view_url;
            }, delay);
        }
    };
    //////////////// Delete ///////////////////
    ///////////////////////////////////////////
    var deleteItem = function () {
        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.confirm(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "GET";

                Forms.doAction(link, formData, method, view_tbl);
            });
        });
    };
    //////////////// Search ///////////////////
    ///////////////////////////////////////////
    var search = function () {
        $('.searchable').on('input', function (e) {
            e.preventDefault();
            view_tbl.draw(false);
        });

        $('.search').on('click', function (e) {
            e.preventDefault();
            view_tbl.draw(false);
        });

        $('form input').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                view_tbl.draw(false);
            }
        });

        $('.btn-clear').on('click', function (e) {
            e.preventDefault();
            $('.clear').val('');
            $('.clear').selectpicker("refresh");
        });
    };
    ///////////////// Initialize //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            add();
            addSupplierFromInvoice();
            edit();
            viewTable();
            search();
            deleteItem();
        }
    }
}();
