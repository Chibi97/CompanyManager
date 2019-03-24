import $ from 'jquery';

function ajax(headers, url, verb, data, cbSuccess, cbFail) {
    if(headers) {
        $.ajaxSetup(headers);
    }

    $.ajax({
        url: url,
        dataType: "json",
        method: verb,
        data: data,
        success: cbSuccess,
        error: cbFail
    });
}

export function ajaxGet(url, cbSuccess, cbFail, headers) {
    ajax(headers, url, "GET", {}, cbSuccess, cbFail);
}

export function ajaxPost(url, data, cbSuccess, cbFail, headers) {
    ajax(headers, url, "POST", data, cbSuccess, cbFail);
}

export function ajaxPut(url, data, cbSuccess, cbFail, headers) {
    ajax(headers, url, "PUT", data, cbSuccess, cbFail);
}

export function ajaxDelete(url, cbSuccess, cbFail, headers) {
    ajax(headers, url, "DELETE", {}, cbSuccess, cbFail);
}
