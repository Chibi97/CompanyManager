import $ from "jquery";
import {ajaxDelete, ajaxGet, ajaxPut} from "./ajax_helpers";
import {
    addLoadingSpinner, afterHttpAction, fillDropDown, setFormFieldForUser, validateUpdateUsers, cleanFields
} from "./form_handlers";

export default function() {
    // ------------ SHOW USER INFO ------------
    var userSelect = $("#onChangeUser");
    userSelect.change(function () {
        var id = $(this).val();
        var url = baseUrl + `/api/users/${id}`;

        if($(this).val() != 0) {
        $(".form-loading").css('display', 'flex');
            ajaxGet(url, (data) => {
                $(".form-loading").css('display', 'none');
                setFormFieldForUser(data);
                var val = false;
                if(data.self) {
                    val = true;
                }
                $('#role').prop('disabled', val);
                $('#btnOpenModalUser').prop('disabled', val);

            }, () => {
                $(".form-loading").css('display', 'none');
                $("#message-target").flash("Server error. Please try later or contact web masters.",
                      {type: "danger", fade: 5000});
                });
        } else {
            cleanFields([$("#fname"), $("#lname"), $("#email"), $('select[name="role"]') ]);
            $('.user-status').html("Status");

        }
    })

    //------------ ARCHIVE A USER ------------
    if($('#updateUserForm').data('page') == 'users') {
        var btnArchiveUser = $('#btnArchiveItem');
        var userId;
        var btnOpenModalUser = $('#btnOpenModalUser');

        btnOpenModalUser.click(function (e) {
            userId = $(this).data('id');
            if(userSelect.val() == 0 ) {
                $("#message-target").flash("Please select an employee", {type: "danger", fade: 5000});
                e.stopPropagation();
            }
        });

        btnArchiveUser.click(function() {
            var oldState = $(this).html();
            var url = `${baseUrl}/api/users/${userId}`;

            if(userId != 0) {
                addLoadingSpinner($(this));
                ajaxDelete(url, function(msg) {
                    fillDropDown(userSelect);
                    afterHttpAction(oldState, msg,  $("#response-msg"), $(this));
                    setTimeout(function () {
                        $('#confirmDeleteModal').modal('toggle');
                        $('.modal-backdrop').attr('class', '');
                    }, 1000);
                    userSelect.val(0);
                    cleanFields([$("#fname"), $("#lname"), $("#email"), $('select[name="role"]') ]);
                    $('.user-status').html("Status");
                    btnArchiveUser.html(oldState);
                    btnArchiveUser.attr('disabled', false);

                }, () => {
                    $("#response-msg").flash("Server error. Please try later or contact web masters.",
                        {type: "danger", fade: 5000});
                });
            }
        })

    }


// ------------ UPDATE USER ------------
    var roleChanged = false;
    var btnUpdateUser = $('#btn-update-user');
    var updateUser = $("#updateUserForm");

    $('#role').change(function() {
        roleChanged = true;
    })

    updateUser.submit(function(e) {

        e.preventDefault();
        var errors = {};
        var valid  = {};
        var id = btnUpdateUser.data('id');

        var idSel = $("#role").val();
        var str;
        if(idSel == 1) {
            str = "promote"
        } else {
            str = "demote";
        }

        if(!validateUpdateUsers(valid, errors)) {
            if(userSelect.val() == 0 ) {
                $("#message-target").flash("Please select an employee", {type: "danger", fade: 5000});
            } else {
                $("#message-target").flash(errors, {type: "danger", fade: 5000});
            }
        } else {
            let message;
            let oldState = btnUpdateUser.html();

            const fn = () => {
                afterHttpAction(oldState, message, $("#message-target"), btnUpdateUser);
            }

            addLoadingSpinner(btnUpdateUser);

            ajaxPut(`${baseUrl}/api/users/${id}`, valid, function(msg) {
                message = msg;
                fn();
                fillDropDown(userSelect);

            }, (xhr) => {
                var resp = JSON.parse(xhr.responseText);
                var msg = "";
                if(resp.errors.email) {
                    msg = resp.errors.email[0];
                } else {
                    msg = "Please provide valid information or contact web master.";
                }
                $("#message-target").flash(msg, {type: "danger", fade: 5000});
                btnUpdateUser.html(oldState);
                btnUpdateUser.attr('disabled', false);
            });

            if(roleChanged) {
                ajaxPut(`${baseUrl}/api/users/${id}/${str}`, {}, function() {
                    fn();
                }, (xhr) => {
                    $("#message-target").flash(JSON.parse(xhr.responseText).message, {type: "danger", fade: 5000});
                    btnUpdateUser.html(oldState);
                    btnUpdateUser.attr('disabled', false);
                });
            }
        }
    })
}
