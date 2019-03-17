try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

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

    var ajax = true;
    var updateUser = $("form[name='updateUserForm']");
    updateUser.submit(function(e) {
        var errors = {};
        var valid  = {};
        var id = $("#fname").data('id');
        var idSel = $("#role").val();

        var str;
        if(idSel == 1) {
            str = "promote"
        } else {
            str = "demote";
        }

        if(!validateUpdateUsers(valid, errors)) {
            e.preventDefault();
            showErrors(errors, $(this));
        } else if(ajax){
            e.preventDefault();
            $(this).find('input, select, button').attr('disabled', true);
            ajaxPut(`/api/users/${id}/${str}`, {}, function() {
                ajax = false;
                updateUser.submit();
            });

        } else {
            $(this).find('input, select, button').attr('disabled', false);
        }
    })
})

function showErrors() {
    alert('work in progress');
}

function validateUpdateUsers(valid, errors) {
    var validations = [];
    var form = $("form[name='updateUserForm']");
    var firstName = form.find('#fname').val();
    var lastName  = form.find('#lname').val();
    var email     = form.find('#email').val();
    var password  = form.find('#pass').val();
    var role      = form.find('#role').val();

    validations.push(validateName(firstName, valid, errors, "firstName"));
    validations.push(validateName(lastName, valid, errors, "lastName"));
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
            console.log(xhr.status, xhr.responseText);
        }
    })
}






