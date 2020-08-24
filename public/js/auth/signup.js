window.onbeforeunload = function () {
    var fields = getFields();
    var formData = {};

    fields.forEach(function (fieldName) {
        var fieldValue = $("#" + fieldName).val();
        formData[fieldName] = fieldValue;
    });

    sessionStorage.setItem('form-data', JSON.stringify(formData));
}

window.onload = function () {
    var fields = getFields();
    var formData = JSON.parse(sessionStorage.getItem('form-data'));

    fields.forEach(function (fieldName) {
        var fieldValue = formData[fieldName];

        if (fieldName !== null) $("#" + fieldName).val(fieldValue);
    });
}

function getFields() {
    return [
        'first-name',
        'last-name',
        'email',
        'birth-date',
        'country',
    ];
}
