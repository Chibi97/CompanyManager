import {ajaxGet} from "./ajax_helpers";
import $ from "jquery";
var moment = require('moment');
moment().format();

export function validateName(name, valid, errors, inputName) {
    var reName = /^[A-Z][a-z]{1,48}(\s([A-Z][a-z]{1,48}))*$/;
    if(reName.test(name)) {
        valid[inputName] = name;
    } else {
        var desc = inputName.split("_");
        desc = (desc[0].charAt(0).toUpperCase() + desc[0].slice(1)) + " " + desc[1];
        errors[inputName] = `${desc} should have capital letters and must be at least 2 characters.`;
    }
}

export function validateEmail(email, valid, errors) {
    var reEmail = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
    if(reEmail.test(email)) {
        valid.email = email;
    } else {
        errors.email = "You must enter a valid format for email address.";
    }
}

export function validatePassword(pass, valid, errors) {
    var rePass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#^\(\)\+\=\-\`\[\]\{\}\;\:\'\"\\\|\/\,\.])[A-Za-z\d@$!%*?&_#^^\(\)\+\=\-`\[\]\{\}\;\:\'\"\\\|\/\,\.]{8,}$/;
    if(rePass.test(pass) || pass == "") {
        valid.password = pass;
    } else {
        errors.password = "A password must have at least one digit, at least one uppercase char, lowercase chars, at least one special char and it should be at least 8 chars long.";
    }

}

export function validateSelectBoxWithWords(field, valid, errors, input, callback) {
    ajaxGet(baseUrl + '/api/task-priorities', (resp) => {
        var names = [];
        resp.forEach(function ($elem) {
            names.push($elem.name);
        })
        if(names.includes(field)) {
            valid[input] = field;
        } else {
            errors[input] = `You must choose an existing item in the ${input} select box.`;
        }
        callback();
    }, () => {
        $("#message-target").flash("Server error. Please try later or contact web masters.",
            {type: "danger", fade: 5000});
    });
}


export function validateSelectBox(item, valid, errors, input, maxId = 1) {
    if(item <= 0 || item > maxId) {
        errors[input] = `You must choose an existing item in the ${input} select box.` ;
    } else {
        valid[input] = item;
    }
}

export function validateSimpleField(field, valid, errors, input, min, max) {
    var regex = new RegExp(`^.{${min},${max}}[^;<>]$`);
    if(regex.test(field)) {
        valid[input] = field;
    } else {
        errors[input] = `Task ${input} should be between ${min}-${max} characters and cannot include ;<> characters.`;
    }
}

export function validateNumber(num, valid, errors) {
    if(parseInt(num) >= 0) {
        valid.count = num;
    } else {
        errors.count = "Number of employees should be 1 or more";
    }

}

export function validateMultiSelectBox(array, valid, errors, input) {
    if(array && array.length > 0) {
        var ids = array.map(function (elem) {
            return parseInt(elem);
        });
        valid[input] = ids;
    } else {
        errors[input] = `You must choose an existing item in the ${input} select box.`;
    }
}

function formatDate(date) {
    return moment(date).format('YYYY-MM-DD HH:mm:ss');
}

function isDateValid(date) {
    date = moment(date, "YYYY-MM-DD HH:mm:ss");
    return date.isValid();
}

function isDateAfterSpecDate(startDate, endDate) {
    return moment(endDate).isSameOrAfter(startDate)
}

function formatDateResponse(date, valid, errors, input, invalidMessage) {
    if(date = formatDate(date)) {
        valid[input] = date;
    } else errors['date'] = invalidMessage;
}

export function validateDate(startDate, endDate, valid, errors) {
    var invalidMessage = 'Insert a valid date in format MM/DD/YYYY HH:mm.';

    if(isDateValid(startDate) && isDateValid(endDate)) {
       if(!isDateAfterSpecDate(startDate, endDate)) {
           errors['date'] = 'End-Date must occur AFTER Start-Date!';
       } else {
          formatDateResponse(startDate, valid, errors, 'start_date', invalidMessage);
          formatDateResponse(endDate, valid, errors, 'end_date', invalidMessage);
       }
    } else {
        errors['date'] = invalidMessage;
    }
}