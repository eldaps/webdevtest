function setError(err) {
    document.getElementById("error").innerHTML = err;
}

function validateEmail() {
    let mail_format = /^\S+@\S+\.\S+$/;
    let email = document.getElementById("email").value;
    if(email.length == 0) {
        setError('Email address is required');
        return false;
    }
    if(email.match(mail_format)) {
        if(email.substr(email.length-3,3).toLowerCase() == '.co') {
            setError('We are not accepting subscriptions from Colombia emails');
            return false;
        }
        return true;
    } else {
        setError('Please provide a valid e-mail address');
        return false;
    }
}

function validateTOS() {
    if(document.getElementById("agreetos").checked) {
        return true;
    } else {
        setError('You must accept the terms and conditions');
        return false;
    }
}

function validateForm() {
    let result = validateEmail() && validateTOS();
    if(result) {
        setError("");
        var data = $('#form').serialize();
        $.post('subscribe.php', data, (data, textStatus, jqXHR) => {if(data == "true") {
            document.getElementById("subscribeform").style.display = 'none';
            document.getElementById("thankspanel").style.display = 'block';
        } else {setError(data); /* JS validation success, PHP validation failed, show server error message */}});
        return false;
    } else {
        let button = document.getElementById("emailsubmit");
        button.disabled = true;
        // Check if the error has been corrected every 500 ms
        setTimeout(errorCheck, 500, button);
    }
    return false;
}

function errorCheck(button) {
    let result = validateEmail() && validateTOS();
    if(result) {
        setError("");
        button.disabled = false;
    } else {
        setTimeout(errorCheck, 500, button);
    }
}