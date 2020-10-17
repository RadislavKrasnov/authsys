$(document).ready(function() {
    $('#save-settings-button').click(function() {
        openConfirmationModal(
            'settings-form',
            'Update settings',
            'Are you sure that you want to update settings?'
        );
    });

    $('#change-email-button').click(function() {
        openConfirmationModal(
            'change-email-form',
            'Change email',
            'Are you sure that you want to change email?'
        );
    });

    $('#reset-password-button').click(function() {
        openConfirmationModal(
            'reset-password-form',
            'Reset password',
            'Are you sure that you want to reset password?'
        );
    });

    $('#delete-account-button').click(function() {
        openConfirmationModal(
            'delete-account-form',
            'Delete account',
            'Are you sure that you want to delete your account?'
        );
    });
});
