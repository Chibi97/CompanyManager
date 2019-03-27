import $ from "jquery";
import {addLoadingSpinner, afterHttpAction, validateTask, cleanFields} from "./form_handlers";
import {ajaxPost, ajaxPut, ajaxDelete} from "./ajax_helpers";


export default function() {

    // ------------ ADD NEW TASK ------------
    var btnAddTask = $("#btn-add-task");
    var addTaskForm = $('#addTask');
    addTaskForm.submit(function (e) {
        e.preventDefault();
        var valid = {};
        var errors = {};

        validateTask(valid, errors, $(this))
            .then((formIsValid) => {
                if(!formIsValid) {
                    $("#message-target").flash(errors, {type: "danger", fade: 5000});
                } else {
                    var oldState = btnAddTask.html();
                    var url = baseUrl + `/api/tasks`;
                    addLoadingSpinner(btnAddTask);
                    ajaxPost(url, valid, (resp) => {
                        afterHttpAction(oldState, resp, $("#message-target"), btnAddTask);
                        cleanFields([
                            $('#tname'),
                            $('#desc'),
                            $('#count')]);

                    }, () => {
                        $("#message-target").flash("Server error. Please try later or contact web masters.",
                            {type: "danger", fade: 5000});
                    });
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

        validateTask(valid, errors, $(this))
            .then((formIsValid) => {
                if(!formIsValid) {
                    $("#message-target").flash(errors, {type: "danger", fade: 5000});
                } else {
                    var oldState = btnUpdateTask.html();
                    addLoadingSpinner(btnUpdateTask);
                    ajaxPut(url, valid, (resp) => {
                        afterHttpAction(oldState, resp, $("#message-target"), btnUpdateTask);
                    }, () => {
                        $("#message-target").flash("Server error. Please try later or contact web masters.",
                            {type: "danger", fade: 5000});
                    });
                }
            });
    })


    // ------------ ARCHIVE A TASK ------------
    if($('.tasks-container').data('page') == 'tasks') {
        var taskId;
        var btnOpenModalArchiveTask = $('.btnOpenModalArchiveTask');
        btnOpenModalArchiveTask.click(function () {
            taskId = $(this).data('id');
        });

        var btnArchiveTask = $('#btnArchiveItem');
        btnArchiveTask.click(function(e) {
            e.preventDefault();
            var oldState = $(this).html();
            var url = `${baseUrl}/api/tasks/${taskId}`;
            addLoadingSpinner($(this));
            ajaxDelete(url, function(msg) {
                afterHttpAction(oldState, msg, $("#response-msg"), $(this));
                setTimeout(function () {
                    $('#confirmDeleteModal').modal('toggle');
                    $('.modal-backdrop').attr('class', '');
                }, 1000)
            },() => {
                $("#response-msg").flash("Server error. Please try later or contact web masters.",
                    {type: "danger", fade: 5000});
            });
        })
    }

}