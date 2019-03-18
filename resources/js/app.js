try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

import init from './flash';
init($);

var baseUrl = window.location.origin;




$(document).ready(function () {
    var form = $("#date-filters");
    var dateSelect = $(".select-change");
    dateSelect.each(function () {
        $(this).val($(this).data('selected'))
    })
    dateSelect.on('input', function () {
        form.submit()
    })

    var headers = {
        headers: {
            'Authorization': $('meta[name="api_token"]').attr('content')
        }
    }
    var userSelect = $("#onChangeUser");
    fillDropDown(headers, userSelect);

    userSelect.change(function () {
        var id = $(this).val();
        var url = baseUrl + `/api/users/${id}`;


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

    var counter = 0;
    var updateUser = $("form[name='updateUserForm']");
    updateUser.submit(function(e) {
        e.preventDefault();
        var errors = {};
        var valid  = {};
        var id = $("#fname").data('id');
        var idSel = $("#role").val();
        $('#updateUserForm').attr('action', `${baseUrl}/company/users/${id}`);

        var str;
        if(idSel == 1) {
            str = "promote"
        } else {
            str = "demote";
        }

        if(!validateUpdateUsers(valid, errors)) {
            $("#message-target").flash(errors, {type: "warning", fade: 3000});
            showMessages(errors, updateUser, 'warning');
        } else {
            let message;
            let old = $("#btn-update-user").html();

            const fn = () => {
                if(counter == 2) {
                    $("#message-target").flash(message, {type: "success", fade: 3000});
                    $("#btn-update-user").html(old);
                    $("#btn-update-user").attr('disabled', false);
                    counter = 0;
                }
            }

            $("#btn-update-user").html(`<div class="semipolar-spinner" :style="spinnerStyle">
                                            <div class="ring"></div>
                                            <div class="ring"></div>
                                            <div class="ring"></div>
                                            <div class="ring"></div>
                                            <div class="ring"></div>
                                        </div>`);
            $("#btn-update-user").attr('disabled', true);

            ajaxPut(`${baseUrl}/api/users/${id}`, valid, function(msg) {
                counter++;
                message = msg;
                fn();
            });

            ajaxPut(`${baseUrl}/api/users/${id}/${str}`, {}, function() {
                counter++;
                fn();
            });
        }
    })
})

function validateUpdateUsers(valid, errors) {
    var validations = [];
    var form = $("form[name='updateUserForm']");
    var firstName = form.find('#fname').val();
    var lastName  = form.find('#lname').val();
    var email     = form.find('#email').val();
    var password  = form.find('#pass').val();
    var role      = form.find('#role').val();

    validations.push(validateName(firstName, valid, errors, "first_name"));
    validations.push(validateName(lastName, valid, errors, "last_name"));
    validations.push(validateEmail(email, valid, errors));
    validations.push(validatePassword(password, valid, errors));
    validations.push(validateSelectBox(role, valid, errors, "role", 2));
    return !validations.includes(false);
}

function validateName(name, valid, errors, inputName) {
    var reName = /^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}))*$/;
    if(reName.test(name)) {
        valid[inputName] = name;
        return true;
    } else {
       // var name =
        errors[inputName] = "Name should have capital letters and must be at least 2 characters.";
        return false;
    }
}

function validateEmail(email, valid, errors) {
    var reEmail = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
    if(reEmail.test(email)) {
        valid.email = email;
        return true;
    } else {
        errors.email = "You must enter a valid format for email address";
        return false;
    }
}

function validatePassword(pass, valid, errors) {
    var rePass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#^\(\)\+\=\-\`\[\]\{\}\;\:\'\"\\\|\/\>\<\,\.])[A-Za-z\d@$!%*?&_#^^\(\)\+\=\-`\[\]\{\}\;\:\'\"\\\|\/\>\<\,\.]{8,}$/;
    if(rePass.test(pass) || pass == "") {
        valid.password = pass;
        return true;
    } else {
        errors.password = "A password must have at least one digit, at least one uppercase char, lowercase chars, at least one special char and it should be at least 8 chars long";
        return false;
    }

}

function validateSelectBox(item, valid, errors, input, maxId) {
    if(item <= 0 || item > maxId) {
        errors[input] = `You must choose an existing item in the ${input} select box` ;
        return false;
    } else {
        valid[input] = item;
        return true;
    }
}

function fillDropDown(headers, ddl) {
    ajaxGet(`${baseUrl}/api/users`, (resp) => {
        resp.forEach((item) => {
           // $('')
        });

    }, headers);
}

function setFormFieldForUser(user) {
    $('#updateUserForm').attr('action', `${baseUrl}/company/users/${user.id}`);
    $('#fname').data('id', user.id);
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
    __ajax(headers, url, "POST", cbSuccess, data);
}

function ajaxPut(url, data, cbSuccess, headers) {
    __ajax(headers, url, "PUT", cbSuccess, data)
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
            console.log(xhr.status, msg);
        }
    })
}






