$.validator.addMethod("alphanumeric", function (value) {
    return /[a-zA-Z0-9]+/.test(value);
}, 'This field should contain only alphabetic characters and numeric');

$.validator.addMethod("password", function (value) {
    return /^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,}$/.test(value);
}, 'This field should contain at least one lowercase and uppercase letter, one number, one specific character and have at least 8 characters');

$.validator.addMethod("usa_date_format", function (value) {
    return /(19|20)\d\d[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])/.test(value);
}, 'This field should be in MM/DD/YYYY format');
