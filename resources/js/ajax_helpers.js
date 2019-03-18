import $ from 'jquery';

function ajax(headers, url, verb, cbSuccess, data) {
    var data = data || {};

    if(headers) {
        $.ajaxSetup(headers);
    }

    $.ajax({
        url: url,
        dataType: "json",
        method: verb,
        success: cbSuccess,
        data: data,
        error: function (xhr, statusText, msg) {
            console.log(xhr.status, msg);
        }
    })
}

export function ajaxGet(url, cbSuccess, headers) {
    ajax(headers, url, "GET", cbSuccess);
}

export function ajaxPost(url, data, cbSuccess, headers) {
    ajax(headers, url, "POST", cbSuccess, data);
}

export function ajaxPut(url, data, cbSuccess, headers) {
    console.log(headers);
    ajax(headers, url, "PUT", cbSuccess, data)
}

export function ajaxDelete(url, cbSuccess, headers) {
    ajax(headers, url, "DELETE", cbSuccess)
}