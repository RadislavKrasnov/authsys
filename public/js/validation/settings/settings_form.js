$(function () {
    $("form[id='settings-form']").validate(getValidationRules());
});

$(function () {
    $("form[id='reset-password-form']").validate(getValidationRules());
});

$(function () {
    $("form[id='change-email-form']").validate(getValidationRules());
});
