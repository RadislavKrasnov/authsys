$(function () {
    $("form[id='signup-form']").validate({
        rules: {
            'first-name': {
                required: true,
                alphanumeric: true
            },
            'last-name': {
                required: true,
                alphanumeric: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                password: true
            },
            'confirmation-password': {
                required: true,
                password: true
            },
            'birth-date': {
                required: true,
                usa_date_format: true
            },
            country: {
                required: true,
                digits: true
            },
            city: {
                required: true,
                digits: true
            },
            region: {
                digits: true,
            }
        },
        messages: {
            'first-name': {
                required: 'Please enter your first name'
            },
            'last-name': {
                required: 'Please enter your last name',
            },
            email: {
                required: 'Please enter your email',
                email: 'This entry should be an email ex. example@domain.com'
            },
            password: {
                required: 'Please enter your password',
            },
            'confirmation-password': {
                required: 'Please enter your password again',
            },
            'birth-date': {
                required: 'Please choose your birth date',
            },
            country: {
                required: 'Please choose your country',
                digits: 'It should be numbers only'
            },
            city: {
                required: 'Please choose your city',
                digits: 'It should be numbers only'
            },
            region: {
                digits: 'It should be numbers only',
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
