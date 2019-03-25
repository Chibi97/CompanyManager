import $ from "jquery";
import 'select2';
import 'bootstrap';
import {setupAjax} from "./ajax_helpers";

var moment = require('moment');
moment().format();

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    setupAjax();
} catch (e) {
}

import flashInit from './flash';
import manageTasks from "./task_management";
import manageUsers from './user_management';
flashInit();
window.baseUrl = window.location.origin;

$(document).ready(function () {
    var form = $("#date-filters");
    var dateSelect = $(".select-change");
    dateSelect.each(function () {
        $(this).val($(this).data('selected'))
    })
    dateSelect.on('input', function () {
        form.submit()
    })

    var selectBoxUsers = $('#selectMultipleUsers');
    selectBoxUsers.select2();
    manageTasks();
    manageUsers();
})






