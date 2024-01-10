
var Settings = function () {
/////////////////// EDIT //////////////////
///////////////////////////////////////////
var edit = function () {
    $('#frmEditSetting').submit(function(e) {
        e.preventDefault();
        var link = $(this).attr('action');
        var formData = $(this).serialize();
        var method = $(this).attr('method');
        Forms.doAction(link, formData, method, null, editCallBack);
    });
};

var editCallBack = function (obj) {
    if(obj.code === 200) {

        var delay = 1000;

        setTimeout(function () {
            $(".save").removeClass("m-loader m-loader--light m-loader--left").html('Save Changes').removeAttr('disabled');
        }, delay);
    }
};
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            edit();
        }
    }
}();