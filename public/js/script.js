let email = document.getElementById('adding_form_email');
let emailCheckbox = document.getElementById('mail-checkbox');
let username = document.getElementById('adding_form_username');
let usernameCheckbox = document.getElementById('username-checkbox');
let password = document.getElementById('adding_form_password');
let passwordCheckbox = document.getElementById('password-checkbox');

email.disabled = true
username.disabled = true
password.disabled = true

function onEmail()
{
    if (emailCheckbox.checked)
    {
        email.disabled = false
    }
    else
    {
        email.disabled = true
    }
}

function onUsername()
{
    if (usernameCheckbox.checked)
    {
        username.disabled = false
    }
    else
    {
        username.disabled = true
    }
}
function onPassword()
{
    if (passwordCheckbox.checked)
    {
        password.disabled = false
    }
    else
    {
        password.disabled = true
    }
}
