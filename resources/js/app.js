import $ from "jquery";
import 'select2';
import 'bootstrap';
var moment = require('moment');
moment().format();

console.log($.fn.modal.toString());

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

import flashInit from './flash';
import {validateUpdateUsers, fillDropDown, setFormFieldForUser, addLoadingSpinner, afterHttpAction, validateTask} from './form_handlers';
import {ajaxGet, ajaxPut, ajaxDelete, ajaxPost} from "./ajax_helpers";
flashInit();
window.baseUrl = window.location.origin;
window.headers = {
    headers: {
        'Authorization': $('meta[name="api_token"]').attr('content')
    }
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

    // ------------ ADD NEW TASK ------------
    var btnAddTask = $("#btn-add-task");
    var selectBoxUsers = $('#selectMultipleUsers');
    selectBoxUsers.select2();

    var addTaskForm = $('#addTask');
    addTaskForm.submit(function (e) {
        e.preventDefault();
        var valid = {};
        var errors = {};

        validateTask(valid, errors, $('#addTask'))
            .then((formIsValid) => {
                if(!formIsValid) {
                    $("#message-target").flash(errors, {type: "warning", fade: 5000});
                } else {
                    var oldState = btnAddTask.html();
                    var url = baseUrl + `/api/tasks`;
                    addLoadingSpinner(btnAddTask);
                    ajaxPost(url, valid, (resp) => {
                        afterHttpAction(oldState, resp, $("#message-target"), btnAddTask);
                    }, headers);
                }
            });
    })

    // ------------ UPDATE A TASK ------------
    var btnUpdateTask = $("#btn-update-task");

    var updateTaskForm = $('#updateTask');
    updateTaskForm.submit(function (e) {
        e.preventDefault();
        var valid = {};
        var errors = {};
        var id = $('#tname').data('id');
        var url = baseUrl + `/api/tasks/${id}`;

        validateTask(valid, errors, $('#updateTask'))
            .then((formIsValid) => {
                if(!formIsValid) {
                    $("#message-target").flash(errors, {type: "warning", fade: 5000});
                } else {
                    var oldState = btnUpdateTask.html();
                    addLoadingSpinner(btnUpdateTask);
                    ajaxPut(url, valid, (resp) => {
                        afterHttpAction(oldState, resp, $("#message-target"), btnUpdateTask);
                    }, headers);
                }
            });
    })

    // ------------ ARCHIVE A TASK ------------
    var taskId;
    var btnOpenModalArchiveTask = $('.btnOpenModalArchiveTask');
    btnOpenModalArchiveTask.click(function () {
        taskId = $(this).data('id');
    });

    var btnArchiveTask = $('#btnArchiveTask');
    btnArchiveTask.click(function(e) {
        e.preventDefault();
        var oldState = btnArchiveTask.html();
        var url = `${baseUrl}/api/tasks/${taskId}`;
        addLoadingSpinner(btnArchiveTask);
        ajaxDelete(url, function(msg) {
            afterHttpAction(oldState, msg, $("#response-msg"), btnArchiveTask);
            setTimeout(function () {
                $('#archiveTaskModal').modal('toggle');
                $('.modal-backdrop').attr('class', '');
            }, 1000)
        }, headers);

    })


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

    // ------------ ARCHIVE USER ------------
    var btnArchiveUser = $("#btn-archive-user");
    var archiveUser = $("#archive-user");
    archiveUser.submit(function (e){
        e.preventDefault();
        var id = $("#onChangeUser").val();
        if(id != 0) {
            var oldState = btnArchiveUser.html();
            addLoadingSpinner(btnArchiveUser);
            ajaxDelete(`${baseUrl}/api/users/${id}`, function(msg) {
                afterHttpAction(oldState, msg, $("#message-target"), btnArchiveUser);
                fillDropDown(headers, userSelect);
            }, headers);
        } else {
            $("#message-target").flash("Please select an employee", {type: "danger", fade: 5000});
        }

    })

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

})






