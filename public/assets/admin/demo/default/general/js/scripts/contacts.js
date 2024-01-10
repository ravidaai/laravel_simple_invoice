/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */

var Contacts = function () {

    var view_tbl;
    var view_url = contacts_view;
    var list_url = contacts_list;
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "name", "orderable": true, "searchable": true},
            {"data": "display_name", "orderable": true, "searchable": true},
            {"data": "company_id", "orderable": true, "searchable": true},
            {"data": "email", "orderable": true, "searchable": true},
            {"data": "mobile", "orderable": true, "searchable": true},
            {"data": "country_id", "orderable": true, "searchable": true},
            {"data": "city_id", "orderable": true, "searchable": true},
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

        view_tbl = DataTable.init($('#contacts_table'), link, columns, order, ajaxFilter, perPage);
    };
    /////////////////// ADD ///////////////////
    ///////////////////////////////////////////
    var add = function () {
        $('#frmAddContact').submit(function(e) {
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
    //////// ADD CONTACT FROM INVOICE /////////
    ///////////////////////////////////////////
    var addItemFromInvoice = function () {
        $('#frmAddContactFromInvoice').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, addItemFromInvoiceCallBack);
        });
    };

    var addItemFromInvoiceCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                $('#addNewContactModal').modal('hide');
                $("#contact_id").append(new Option(obj.data.name, obj.data.id));
                $('#contact_id').selectpicker('refresh');
            }, delay);
        }
    };
    /////////////////// EDIT //////////////////
    ///////////////////////////////////////////
    var edit = function () {
        $('#frmEditContact').submit(function(e) {
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
    //////////////// DELETE ///////////////////
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
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            add();
            addItemFromInvoice();
            edit();
            viewTable();
            search();
            deleteItem();
        }
    }
}();