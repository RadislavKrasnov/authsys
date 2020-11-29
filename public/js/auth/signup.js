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

    if (!formData) {
        return;
    }

    if (formData['country']) {
        $.ajax({
            type: "POST",
            url: "/regions",
            data: { country_id : formData['country'] }
        }).done(function(regions) {
            var regions = JSON.parse(regions);
            var regionField = $("#region");
            regionField.html(regions.html);

            if (formData['region']) {
                regionField.val(formData['region']);
                loadChosenCity(formData['region'], formData['city']);
            } else {
                regionField.val(regions.firstRegionId);
                loadChosenCity(regions.firstRegionId, formData['city']);
            }
        });
    }

    fields.forEach(function (fieldName) {
        var fieldValue = formData[fieldName];
        if (fieldName !== null) $("#" + fieldName).val(fieldValue);
    });
}

function loadChosenCity(regionId, cityId) {
    $.ajax({
        type: "POST",
        url: "/cities",
        data: { region_id : regionId }
    }).done(function(data){
        var cityField = $("#city");
        cityField.html(data);

        if (cityId) {
            cityField.val(cityId);
        }
    });
}

function getFields() {
    return [
        'first-name',
        'last-name',
        'email',
        'birth-date',
        'country',
        'region',
        'city'
    ];
}
