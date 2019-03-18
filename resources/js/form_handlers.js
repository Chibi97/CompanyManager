import {validateEmail, validateName, validatePassword, validateSelectBox} from "./validation";
import {ajaxGet} from "./ajax_helpers";
import $ from "jquery";

export function validateUpdateUsers(valid, errors) {
    var form = $("form[name='updateUserForm']");
    var firstName = form.find('#fname').val();
    var lastName  = form.find('#lname').val();
    var email     = form.find('#email').val();
    var password  = form.find('#pass').val();
    var role      = form.find('#role').val();

    validateName(firstName, valid, errors, "first_name");
    validateName(lastName, valid, errors, "last_name");
    validateEmail(email, valid, errors);
    validatePassword(password, valid, errors);
    validateSelectBox(role, valid, errors, "role", 2);
    return Object.keys(errors).length == 0;
}

export function fillDropDown(headers, ddl) {
    var options = "";
    ajaxGet(`${baseUrl}/api/users`, (resp) => {
        var selected = ddl.val();

        resp.forEach((item) => {
            if(item.id == selected) {
                options += `<option selected value=${item.id}>${item.first_name} ${item.last_name}</option>`;
            }
            options += `<option value=${item.id}>${item.first_name} ${item.last_name}</option>`;
        });

        ddl.html(options);
    }, headers);
}

export function setFormFieldForUser(user) {
    $('#updateUserForm').attr('action', `${baseUrl}/company/users/${user.id}`);
    $('#fname').data('id', user.id);
    $("#fname").val(user.first_name);
    $("#lname").val(user.last_name);
    $("#email").val(user.email);
    $('select[name="role"]').val(user.role.id);
    $('.user-status').html(user.user_status.name);
}

export function addLoadingSpinner(button) {
    button.html(`<div class="semipolar-spinner" :style="spinnerStyle">
                    <div class="ring"></div>
                    <div class="ring"></div>
                    <div class="ring"></div>
                    <div class="ring"></div>
                    <div class="ring"></div>
                </div>`);
    button.attr('disabled', true);
}

export function afterHttpAction(oldState, message, messageDiv, button) {
    messageDiv.flash(message, {type: "success", fade: 5000});
    button.html(oldState);
    button.attr('disabled', false);
}

