function openConfirmationModal (formId, title, text) {
    var modal = document.getElementById("confirmation-modal");
    document.getElementById('confirmation-modal-title').innerText = title;
    document.getElementById('confirmation-modal-text').innerText = text;
    var confirmationButton = document.getElementsByClassName("confirmation-button")[0];
    confirmationButton.dataset.formId = formId;
    modal.style.display = "block";
}

$(document).ready(function () {
    $('.cancellation-button').on('click', function () {
        var modal = document.getElementById("confirmation-modal");
        modal.style.display = 'none';
    });

    $('.confirmation-button').on('click', function () {
        var formId = $(this).data('formId');
        var modal = document.getElementById("confirmation-modal");
        $('#' + formId).submit();
        modal.style.display = 'none';
    });
});
