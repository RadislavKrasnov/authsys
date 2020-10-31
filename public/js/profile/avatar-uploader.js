$(document).ready(function () {
    $('#avatar-uploader-button').on('click', function () {
        $('input[type=file]').click();
    });

    $("input[name='image']").change(function () {
        this.form.submit();
    });
});
