import $ from "jquery";
import {ajaxDelete, ajaxGet, ajaxPut} from "./ajax_helpers";
import {
    addLoadingSpinner, afterHttpAction, fillDropDown, setFormFieldForUser, validateUpdateUsers
} from "./form_handlers";

export default function() {
    // ------------ SHOW USER INFO ------------
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

// ------------ ARCHIVE A USER ------------
    if($('#updateUserForm').data('page') == 'users') {
        var userId;
        var btnOpenModalUser = $('#btnOpenModalUser');
        btnOpenModalUser.click(function () {
            userId = $(this).data('id');
        });

        var btnArchiveUser = $('#btnArchiveItem');
        btnArchiveUser.click(function(e) {
            e.preventDefault();
            var oldState = $(this).html();
            var url = `${baseUrl}/api/users/${userId}`;

            if(userId != 0) {
                addLoadingSpinner($(this));
                ajaxDelete(url, function(msg) {
                    fillDropDown(headers, userSelect);
                    afterHttpAction(oldState, msg,  $("#response-msg"), $(this));
                    setTimeout(function () {
                        $('#confirmDeleteModal').modal('toggle');
                        $('.modal-backdrop').attr('class', '');
                    }, 1000)
                }, headers);
            } else {
                $("#message-target").flash("Please select an employee", {type: "danger", fade: 5000});
            }
        })
    }


// ------------ UPDATE USER ------------
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
            let oldState = $("#btn-update-user").html();

            const fn = () => {
                if(counter == 2) {
                    afterHttpAction(oldState, message, $("#message-target"), $("#btn-update-user"));
                    counter = 0;
                }
            }

            addLoadingSpinner($("#btn-update-user"));

            ajaxPut(`${baseUrl}/api/users/${id}`, valid, function(msg) {
                counter++;
                message = msg;
                fn();
                fillDropDown(headers, userSelect);
            }, headers);

            ajaxPut(`${baseUrl}/api/users/${id}/${str}`, {}, function() {
                counter++;
                fn();
            }, headers);
        }
    })
}
