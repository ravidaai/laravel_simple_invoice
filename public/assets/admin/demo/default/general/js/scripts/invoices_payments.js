/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */

var InvoicesPayments = function () {
    var id = $('#invoice_id').attr('data-id');
    /////////////
    var view_tbl;
    var view_url = 'admin/invoices/payments/' + id;
    var list_url = 'admin/invoices/payments/list/' + id;
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "invoice_id", "orderable": true, "searchable": true},
            {"data": "amount", "orderable": true, "searchable": true},
            {"data": "type", "orderable": true, "searchable": true},
            {"data": "bank_name", "orderable": true, "searchable": true},
            {"data": "bank_branch", "orderable": true, "searchable": true},
            {"data": "transfer_number", "orderable": true, "searchable": true},
            {"data": "created_at", "orderable": true, "searchable": true},
            {"data": "actions", "orderable": false, "searchable": false}
        ];
        var perPage = 25;
        var order = [[2, 'desc']];

        var ajaxFilter = function (d) {
            d.name = $('#name').val();
        };

        view_tbl = DataTable.init($('#invoices_payments_table'), link, columns, order, ajaxFilter, perPage);
    };
    /////////////////// ADD ///////////////////
    ///////////////////////////////////////////
    var add = function () {
        $('#frmAddPayment').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = new FormData(this);
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
    //////////////// DELETE ///////////////////
    ///////////////////////////////////////////
    var deleteItem = function () {
        $(document).on('click', '.delete_btns', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.confirm(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "GET";

                Forms.doAction(link, formData, method, view_tbl, null, deleteCallBack);
            });
        });
    };

    var deleteCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = list_url;
            }, delay);
        }
    };
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            add();
            viewTable();
            deleteItem();
        }
    }
}();