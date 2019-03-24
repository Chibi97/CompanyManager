import {validateEmail, validateName, validatePassword, validateSelectBox, validateSimpleField, validateNumber, validateMultiSelectBox, validateDate, validateSelectBoxWithWords} from "./validation";
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

export function validateTask(valid, errors, form) {
    var name      = form.find('#tname').val();
    var desc      = form.find('#desc').val();
    var count     = form.find('#count').val();
    var startDate = form.find('#startDate').val();
    var endDate   = form.find('#endDate').val();
    var employees = form.find('#selectMultipleUsers').val();
    var priority  = form.find('#priority').val();

    const done = () => {
        return Object.keys(errors).length == 0;
    };

    return new Promise((resolve) => {
        validateSimpleField(name, valid, errors, "name", 3,50);
        validateSimpleField(desc, valid, errors, "description", 10,190);
        validateSelectBoxWithWords(priority, valid, errors, "priority", () => {
            validateNumber(count, valid, errors);
            validateMultiSelectBox(employees, valid, errors, "employees");
            validateDate(startDate, endDate, valid, errors);
            resolve(done());
        });
    });
}

export function fillDropDown(headers, ddl) {
    var options = "";
    ajaxGet(`${baseUrl}/api/users`, (resp) => {
        var selected = ddl.val();

        resp.forEach((item) => {
            if(item.id == selected) {
                options += `<option selected value=${item.id}>${item.first_name} ${item.last_name}</option>`;
            } else {
                options += `<option value=${item.id}>${item.first_name} ${item.last_name}</option>`;
            }
        });

        ddl.html(options);
    }, () => {
        $("#message-target").flash("Server error. Please try later or contact web masters.",
            {type: "danger", fade: 5000});
    }, headers);
}

export function setFormFieldForUser(user) {
    $('#updateUserForm').attr('action', `${baseUrl}/company/users/${user.id}`);
    $('#btnOpenModalUser').data('id', user.id);
    $('#btn-update-user').data('id', user.id);
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

