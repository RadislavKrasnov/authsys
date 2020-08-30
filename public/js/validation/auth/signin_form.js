$(function () {
    $("form[id='signin-form']").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                password: true
            },
        },
        messages: {
            email: {
                required: 'Please enter your email',
                email: 'This entry should be an email ex. example@domain.com'
            },
            password: {
                required: 'Please enter your password',
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
