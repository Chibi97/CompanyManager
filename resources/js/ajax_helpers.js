export function setupAjax() {
    const token = $("meta[name='apitoken']").attr('content');
    console.log(token);
    $.ajaxSetup({
        headers: {
            "Authorization": token
        }
    })
}

function ajax(url, verb, data, cbSuccess, cbFail) {
    $.ajax({
        url: url,
        dataType: "json",
        method: verb,
        data: data,
        success: cbSuccess,
        error: cbFail
    });
}

export function ajaxGet(url, cbSuccess, cbFail) {
    ajax(url, "GET", {}, cbSuccess, cbFail);
}

export function ajaxPost(url, data, cbSuccess, cbFail) {
    ajax(url, "POST", data, cbSuccess, cbFail);
}

export function ajaxPut(url, data, cbSuccess, cbFail) {
    ajax(url, "PUT", data, cbSuccess, cbFail);
}

export function ajaxDelete(url, cbSuccess, cbFail) {
    ajax(url, "DELETE", {}, cbSuccess, cbFail);
}
