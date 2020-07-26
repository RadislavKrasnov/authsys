$(document).ready(function(){
    $("select#country").change(function(){
        var selectedCountryId = $("#country option:selected").val();
        $.ajax({
            type: "POST",
            url: "regions",
            data: { country_id : selectedCountryId }
        }).done(function(data){
            $("#region").html(data);
        });
    });
});

$(document).ready(function(){
    $("select#region").change(function(){
        var selectedCountryId = $("#region option:selected").val();
        $.ajax({
            type: "POST",
            url: "cities",
            data: { region_id : selectedCountryId }
        }).done(function(data){
            $("#city").html(data);
        });
    });
});