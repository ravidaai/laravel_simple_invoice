/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 2/28/2019
 * Time: 11:57 AM
 */

// http://dev.semskc.org/
// var base_url = $('base').attr('href');
// base_url += $('html').attr('lang') + '/';

var Forms = function () {

    var serializeForm = function () {
    };

    var notify = function (title, type) {
        new Noty({
            type: type,
            text: title,
            layout: getNotificationLayout(),
            theme    : 'mint',
            timeout    : 1000,
            progressBar    : 1,
            closeWith    : ['click'],
            animation: {
                open : 'animated bounceInDown',
                close: 'animated bounceOutUp'
            },
            speed: 500
        }).show();
    };

    var getNotificationType = function (code) {
        if (code >= 200 && code <= 299) {
            return 'success'
        }
        else if (code >= 300 && code <= 399) {
            return 'info';
        }
        else if (code >= 400 && code <= 499) {
            return 'warning';
        }
        else if (code >= 500 && code <= 599) {
            return 'error';
        }
        else {
            return 'alert';
        }
    };

    var getNotificationLayout = function () {
        return ((Common.getCurrentLanguage() === 'ar' && Common.getCurrentDirection() === 'rtl') ? "topLeft" : "topRight");
    };

    return {
        init: function () {
            serializeForm();
        },
        doAction: function (link, data, type, dataTable, callback, showNotification) {

            var method = (type !== "") ? type : "GET";
            showNotification = (typeof showNotification === "boolean") ? showNotification : true;
            var flag = (typeof(data) === 'string') ? 'application/x-www-form-urlencoded; charset=UTF-8' : false;

            $.ajax({
                type: method,
                url: link,
                data: data,
                dataType: 'json',
                processData: flag,
                contentType: flag,
                success: function (data)
                {
                    if (showNotification) {
                        notify(data.message, getNotificationType(data.code));
                    }

                    if (data.code === 200) {
                        $(".save").addClass("m-loader m-loader--light m-loader--left").html('Saving, please wait, ..').attr("disabled", "disabled");
                        if (dataTable !== null) {
                            dataTable.draw(false);
                        }
                    }

                    if (typeof callback === "function") {
                        callback(data);
                    }
                },
                errors: function (request) {
                    var message = "(";
                    message += request.status;
                    message += ") ";
                    message += request.statusText;

                    notify(message, getNotificationType(500));

                    if(parseInt(request.status) === 401) {
                        var delay = 1750;

                        setTimeout(function() {
                            window.location = base_url;
                        }, delay);
                    }
                }
            });
        },
        loadHTML: function (link, data, type, callback) {

            var method = (type !== "") ? type : "GET";

            $.ajax({
                type: method,
                url: link,
                data: data,
                dataType: 'html',
                success: function (data)
                {
                    if (typeof callback === "function") {
                        callback(data);
                    }
                },
                errors: function (request) {
                    var message = "(";
                    message += request.status;
                    message += ") ";
                    message += request.statusText;

                    notify(message, getNotificationType(500));
                }
            });
        },
        notify: function (message, code) {
            return notify(message, getNotificationType(code));
        }
    }
}();
///////////////////////////
var Common = function () {

    var html_el = $('html');
    var current_language = html_el.attr('lang');
    var current_layout_direction = html_el.attr('dir');

    var detectLang = function () {
        current_language = html_el.attr('lang');
        current_layout_direction = html_el.attr('dir');
    };

    var initializeSelect = function () {
        if ($('.m_selectpicker').length > 0)
        {
            var select = $('select');
            select.selectpicker({
                refresh: true,
                noneSelectedText: select_item,
            });
        }
        // if(select.length) {
        //     select.select2({
        //         minimumResultsForSearch: Infinity,
        //         width: '100%'
        //     });
        // }
    };

    var initializeToken = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };

    return {
        init: function () {
            detectLang();
            initializeSelect();
            initializeToken();

            var styled = $('.styled');

            if(styled.length) {
                styled.uniform({
                    radioClass: 'choice'
                });
            }
        },
        getCurrentLanguage: function () {
            return current_language;
        },
        getCurrentDirection: function () {
            return current_layout_direction;
        },
        confirm: function (callback) {
            swal({
                title: 'Are you sure?',
                text: 'Can\'t be restored later!',
                showCancelButton: true,
                confirmButtonText: "<span><i class='la la-thumbs-up'></i><span> Yes, delete it</span></span>",
                confirmButtonClass: "btn btn-danger m-btn m-btn--pill m-btn--air m-btn--icon",
                cancelButtonText: "<span><i class='la la-thumbs-down'></i><span> No, thanks</span></span>",
                cancelButtonClass: "btn btn-secondary m-btn m-btn--pill m-btn--icon"
            }).then(function(result) {
                if (result.value) {
                    callback();
                }
            });
        },
        generateURL: function(query) {
            return base_url + query;
        },
        redirect: function(query) {
            var delay = 1750;

            setTimeout(function() {
                window.location = Common.generateURL(query);
            }, delay);
        }
    }
}();

$(document).ready(function() {
    Forms.init();
    Common.init();
});