<?php $this->show('profile/header.php'); ?>
<?php if (isset($successMessages) && !empty($successMessages)):
    foreach ($successMessages as $successMessage): ?>
        <p class="success-message"><?= $successMessage ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (isset($messages) && !empty($messages)):
    foreach ($messages as $message): ?>
        <p class="error-message"><?= $message ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<main>
    <section class="content">
        <div class="title">
            <h1>Settings</h1>
            <hr/>
        </div>
        <div class="settings">
            <div class="left-col">
                <form id="settings-form" action="/auth/account/settings/save" method="post">
                    <div class="fieldset">
                        <div class="label">
                            <label for="first-name">First name</label>
                        </div>
                        <div class="field">
                            <input type="text" id="first-name" name="first-name" value="<?= $user->firstName ?>"/>
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="last-name">Last name</label>
                        </div>
                        <div class="field">
                            <input type="text" id="last-name" name="last-name" value="<?= $user->lastName ?>"/>
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="birth-date">Birth date</label>
                        </div>
                        <div class="field">
                            <input type="date" id="birth-date" name="birth-date" value="<?= $user->birthDate ?>"/>
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="country">Country</label>
                        </div>
                        <div class="field">
                            <select name="country" id="country">
                                <option value="">--Please choose an option--</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country->id ?>"
                                        <?= ($country->id == $user->countryId) ? 'selected' : ''; ?>>
                                        <?= $country->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="region">Region</label>
                        </div>
                        <div class="field">
                            <select name="region" id="region">
                                <option value="">--Please choose an option--</option>
                                <?php foreach ($regions as $region): ?>
                                    <option value="<?= $region->id ?>"
                                        <?= ($region->id == $user->regionId) ? 'selected' : ''; ?>>
                                        <?= $region->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="city">City, Town</label>
                        </div>
                        <div class="field">
                            <select name="city" id="city">
                                <option value="">--Please choose an option--</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city->id ?>"
                                        <?= ($city->id == $user->cityId) ? 'selected' : ''; ?>>
                                        <?= $city->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="right-col">
                <form id="reset-password-form" action="/auth/account/settings/password/reset" method="post">
                    <div class="fieldset">
                        <div class="label">
                            <label for="current-password">Current password</label>
                        </div>
                        <div class="field">
                            <input type="password" id="current-password" name="current-password" />
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="password">New Password</label>
                        </div>
                        <div class="field">
                            <input type="password" id="password" name="password" />
                        </div>
                    </div>
                    <div class="fieldset">
                        <div class="label">
                            <label for="confirmation-password">Confirmation password</label>
                        </div>
                        <div class="field">
                            <input type="password" id="confirmation-password" name="confirmation-password" />
                        </div>
                    </div>
                    <button type="button" id="reset-password-button"
                            class="button primary-button" name="reset-password" value="reset_password">
                        Reset Password
                    </button>
                </form>
                <form id="change-email-form" action="/auth/account/settings/email/change" method="post">
                    <div class="fieldset">
                        <div class="label">
                            <label for="email">New email</label>
                        </div>
                        <div class="field">
                            <input type="email" id="email" name="email" placeholder="example@domain.com"
                                   value="<?= $user->email ?>"/>
                        </div>
                    </div>
                    <button type="button" id="change-email-button"
                            class="button primary-button" name="change-email" value="change_email">
                        Change email
                    </button>
                </form>
            </div>
        </div>
        <div class="bottom-row">
            <hr/>
            <button type="button" form="settings-form" id="save-settings-button"
                    class="button primary-button" name="submit-button" value="change_settings">
                Save
            </button>
        </div>
        <div id="confirmation-modal" class="modal-wrapper">
            <div class="modal">
                <div class="modal-header">
                    <span id="confirmation-modal-title"></span>
                </div>
                <div class="modal-content">
                    <p id="confirmation-modal-text"></p>
                </div>
                <div class="modal-footer">
                    <button class="confirmation-button button primary-button">
                        Yes
                    </button>
                    <button class="cancellation-button button primary-button">
                        No
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $this->show('profile/footer.php'); ?>
