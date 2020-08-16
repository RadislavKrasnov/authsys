<?php
if (isset($messages) && !empty($messages)):
    foreach ($messages as $message): ?>
    <p class="error"><?= $message ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<div class="auth-block">
    <div class="title">
        <h2>Sign Up</h2>
    </div>
    <div class="auth-form">
        <form id="signup-form" action="/auth/account/create" method="post">
            <div class="fieldset">
                <div class="label">
                    <label for="first-name">First name</label>
                </div>
                <div class="field">
                    <input type="text" id="first-name" name="first-name" />
                </div>
            </div>
            <div class="fieldset">
                <div class="label">
                    <label for="last-name">Last name</label>
                </div>
                <div class="field">
                    <input type="text" id="last-name" name="last-name" />
                </div>
            </div>
            <div class="fieldset">
                <div class="label">
                    <label for="email">Email</label>
                </div>
                <div class="field">
                    <input type="email" id="email" name="email" placeholder="example@domain.com" />
                </div>
            </div>
            <div class="fieldset">
                <div class="label">
                    <label for="password">Password</label>
                </div>
                <div class="field">
                    <input type="text" id="password" name="password" />
                </div>
            </div>
            <div class="fieldset">
                <div class="label">
                    <label for="confirmation-password">Confirmation password</label>
                </div>
                <div class="field">
                    <input type="text" id="confirmation-password" name="confirmation-password" />
                </div>
            </div>
            <div class="fieldset">
                <div class="label">
                    <label for="birth-date">Birth date</label>
                </div>
                <div class="field">
                    <input type="date" id="birth-date" name="birth-date" />
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
                            <option value="<?= $country->id ?>"><?= $country->name ?></option>
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
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="create-account">
        <button type="submit" form="signup-form" name="submit" value="create_account">
            Create account
        </button>
    </div>
</div>
