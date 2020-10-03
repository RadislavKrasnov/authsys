<?php $this->show('profile/header.php'); ?>
<main>
    <section class="content">
        <div class="title">
            <h1>Settings</h1>
            <hr/>
        </div>
        <div class="settings">
            <div class="left-col">
                <form id="settings-form" action="#" method="post">
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
                            <label for="email">Email</label>
                        </div>
                        <div class="field">
                            <input type="email" id="email" name="email" placeholder="example@domain.com"
                                   value="<?= $user->email ?>"/>
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
                <form id="reset-password-form" action="#" method="post">
                    <div class="fieldset">
                        <div class="label">
                            <label for="password">Password</label>
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
                    <button type="submit" class="primary-button" name="reset-password" value="reset_password">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
        <div class="bottom-row">
            <hr/>
            <button type="submit" form="settings-form" class="primary-button" name="submit" value="change_settings">
                Save
            </button>
        </div>
    </section>
</main>
<?php $this->show('profile/footer.php'); ?>
