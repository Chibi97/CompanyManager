try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

import flashInit from './flash';
import {validateUpdateUsers, fillDropDown, setFormFieldForUser} from './form_handlers';
import {ajaxGet, ajaxPut, ajaxPost} from "./ajax_helpers";

window.baseUrl = window.location.origin;
flashInit();

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
            $("#message-target").flash(errors, {type: "warning", fade: 5000});
        } else {
            let message;
            let old = $("#btn-update-user").html();

            const fn = () => {
                if(counter == 2) {
                    $("#message-target").flash(message, {type: "success", fade: 5000});
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
                fillDropDown(headers, userSelect);
            });

            ajaxPut(`${baseUrl}/api/users/${id}/${str}`, {}, function() {
                counter++;
                fn();
            });
        }
    })
})






