<?php
if (isset($messages) && !empty($messages)):?>
<div class="error-messages">
    <?php foreach ($messages as $message): ?>
        <p class="error-message"><?= $message ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<div class="auth-block">
    <div class="title">
        <h2>Sign In</h2>
    </div>
    <div class="auth-form">
        <form id="signin-form" action="/auth/account/signin" method="post">
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
                    <input type="password" id="password" name="password" />
                </div>
            </div>
        </form>
    </div>
    <div class="signin-button-block">
        <button type="submit" form="signin-form" name="submit" value="sign_in">
            Sign In
        </button>
    </div>
    <div class="auth-links">
        <div class="link">
            <a href="/signup">Sign Up</a>
        </div>
    </div>
</div>
