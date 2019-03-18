export function validateName(name, valid, errors, inputName) {
    var reName = /^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}))*$/;
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
        errors.email = "You must enter a valid format for email address";
    }
}

export function validatePassword(pass, valid, errors) {
    var rePass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#^\(\)\+\=\-\`\[\]\{\}\;\:\'\"\\\|\/\>\<\,\.])[A-Za-z\d@$!%*?&_#^^\(\)\+\=\-`\[\]\{\}\;\:\'\"\\\|\/\>\<\,\.]{8,}$/;
    if(rePass.test(pass) || pass == "") {
        valid.password = pass;
    } else {
        errors.password = "A password must have at least one digit, at least one uppercase char, lowercase chars, at least one special char and it should be at least 8 chars long";
    }

}

export function validateSelectBox(item, valid, errors, input, maxId) {
    if(item <= 0 || item > maxId) {
        errors[input] = `You must choose an existing item in the ${input} select box` ;
    } else {
        valid[input] = item;
    }
}