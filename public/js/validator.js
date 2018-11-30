function validateRegisterForm()
{
    var firstName = document.forms["registerForm"]["firstName"].value;
    var lastName = document.forms["registerForm"]["lastName"].value;
    var password = document.forms["registerForm"]["password"].value;
    var confirmPassword = document.forms["registerForm"]["confirmPassword"].value;
    var response = grecaptcha.getResponse();

    var success = true;

    if (firstName.length < 2 || firstName.length > 35)
    {
        firstNameFeedback.style.display = 'block';
        success = false;
    }

    if (lastName.length < 2 || lastName.length > 35)
    {
        lastNameFeedback.style.display = 'block';
        success = false;
    }

    if (password.length < 8)
    {
        passwordFeedback.style.display = 'block';
        success = false;
    }

    if (password !== confirmPassword)
    {
        confirmPasswordFeedback.style.display = 'block';
        success = false;
    }

    if (response.length == 0)
    {
        recaptchaFeedback.style.display = 'block';
        success = false;
    }

    return success;
}

function validateCreateArticleForm()
{
    var headline = document.forms["createArticleForm"]["headline"].value;
    var content = document.forms["createArticleForm"]["content"].value;

    var success = true;

    if (headline.length < 3 || headline.length > 80)
    {
        headlineFeedback.style.display = 'block';
        success = false;
    }

    if (content.length < 3 || content.length > 63206)
    {
        contentFeedback.style.display = 'block';
        success = false;
    }

    return success;
}
