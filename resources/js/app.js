try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

// window.axios = require('axios');
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     //console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }


let baseUrl = window.location.origin;

$(document).ready(function () {
    var form = $("#date-filters");
    var dateSelect = $(".select-change");
    dateSelect.each(function () {
        $(this).val($(this).data('selected'))
    })
    dateSelect.on('input', function () {
        form.submit()
    })

    var userSelect = $("#onChangeUser");
    userSelect.change(function () {
        var id = $(this).val();
        var url = baseUrl + `/api/users/${id}`;
        var headers = {
            headers: {
                'Authorization': $('meta[name="api_token"]').attr('content')
            }
        }

        if($(this).val() != 0) {
            ajaxGet(url, (data) => { setFormFieldForUser(data); }, headers);
        } else {
            var fields = [$("#fname"), $("#lname"), $("#email"), $('select[name="role"]') ];
            for(field of fields) {
                field.val("");
            }
            $('.user-status').html("Status");
        }
    })
})

function setFormFieldForUser(user) {
    $("#fname").val(user.first_name);
    $("#lname").val(user.last_name);
    $("#email").val(user.email);
    $('select[name="role"]').val(user.role.id);
    $('.user-status').html(user.user_status.name);
}

function ajaxGet(url, cbSuccess, headers) {
    __ajax(headers, url, "GET", cbSuccess);
}

function ajaxPost(url, data, cbSuccess, headers) {
    __ajax(headers, url, "POST", data, cbSuccess);
}

function __ajax(headers, url, verb, cbSuccess, data) {
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
            console.log(xhr.status, xhr.responseText);
        }
    })
}






