$(document).ready(function() {
    $("select#country").change(function() {
        var selectedCountryId = $("#country option:selected").val();

        if (!selectedCountryId) {
            clearOptions('#region');
            clearOptions('#city');

            return;
        }

        $.ajax({
            type: "POST",
            url: "/regions",
            data: { country_id : selectedCountryId }
        }).done(function(regions) {
            var regions = JSON.parse(regions);
            $("#region").html(regions.html);

            if (regions.firstRegionId) {
                getCities(regions.firstRegionId);
            }
        });
    });
});

$(document).ready(function() {
    $("select#region").change(function(){
        var regionId = $("#region option:selected").val();
        getCities(regionId);
    });
});

function getCities(regionId) {
    $.ajax({
        type: "POST",
        url: "/cities",
        data: { region_id : regionId }
    }).done(function(data){
        $("#city").html(data);
    });
}

function clearOptions(fieldIdentifier) {
    $(fieldIdentifier)
        .find('option')
        .remove()
        .end()
        .append('<option value="">--Please choose an option--</option>');
}
