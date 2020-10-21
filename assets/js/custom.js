function AjaxLoading(element) {
    $("#" + element).html("<img src='/assets/img/ajax-loader.gif'>");
}

function RemoveAjaxLoader(element) {
    $("#" + element).html("");
}

function AjaxPost(url, data, callback) {
    // wtf
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "JSON",
        success: callback,
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}