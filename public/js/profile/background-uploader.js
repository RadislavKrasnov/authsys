$(document).ready(function () {
    $('#background-uploader-button').on('click', function () {
        $('#background-uploader-form').find('input[type=file]').click();
    });

    $("input[name='background-image']").change(function () {
        this.form.submit();
    });
});
