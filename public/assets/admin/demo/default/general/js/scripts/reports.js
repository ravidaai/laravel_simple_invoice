/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */

let Reports = function () {

    let view_tbl;
    let list_url = reports_list;
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    let viewTable = function () {
        let link = list_url;
        let columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "number", "orderable": true, "searchable": true},
            {"data": "contact_id", "orderable": true, "searchable": true},
            {"data": "company_id", "orderable": true, "searchable": true},
            {"data": "invoice_date", "orderable": true, "searchable": true},
            {"data": "due_date", "orderable": true, "searchable": true},
            {"data": "subtotal", "orderable": true, "searchable": true},
            {"data": "discount", "orderable": true, "searchable": true},
            {"data": "total", "orderable": true, "searchable": true},
            {"data": "paid", "orderable": true, "searchable": true},
            {"data": "created_at", "orderable": true, "searchable": true},
            {"data": "actions", "orderable": false, "searchable": false}
        ];
        let perPage = 25;
        let order = [[2, 'desc']];

        let ajaxFilter = function (d) {
            d.start_date = $('#start_date').val();
            d.end_date = $('#end_date').val();
            d.item_id = $('#item_id').val();
            d.contact_id = $('#contact_id').val();
            d.studio = $('#studio').val();
        };

        view_tbl = DataTable.init($('#invoices_table'), link, columns, order, ajaxFilter, perPage);
    };
    //////////////// Search ///////////////////
    ///////////////////////////////////////////
    let search = function () {
        $('.searchable').on('input change', function (e) {
            e.preventDefault();
            view_tbl.draw(false);
        });

        // $('.search').on('click', function (e) {
        //     e.preventDefault();
        //     view_tbl.draw(false);
        // });

        $('#m_form_1').on('submit', function (e) {
            e.preventDefault();
            view_tbl.draw(false);

            let link = $(this).attr('action');
            let formData = $(this).serialize();
            let method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, function(obj) {
                $('#no_of_invoices').text(obj.data.no_of_invoices);
                $('#no_of_paid_invoices').text(obj.data.no_of_paid_invoices);
                $('#no_of_unpaid_invoices').text(obj.data.no_of_unpaid_invoices);
                $('#total_of_invoices').text(obj.data.total_of_invoices);
                $('#total_of_paid_invoices').text(obj.data.total_of_paid_invoices);
                $('#total_of_unpaid_invoices').text(obj.data.total_of_unpaid_invoices);
            },false);
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
            viewTable();
            search();
        }
    }
}();