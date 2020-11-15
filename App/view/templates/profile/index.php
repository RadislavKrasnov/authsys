<?php $this->show('profile/header.php'); ?>
<main>
    <section class="user-info-section" id="user-info-section"
             <?php if ($backgroundPhoto): ?>
             style="background-image: url(<?= $imageOptimizer->resizeImage($backgroundPhoto->path, 1000, 400) ?>)"
             <?php endif; ?>>
        <div class="user-info-center">
            <div class="avatar">
                <img src="<?= $imageOptimizer->resizeImage($avatarPath, 260, 260) ?>"
                     alt="<?= $user->firstName . ' ' . $user->lastName ?> avatar" />
                <div class="uploader">
                    <a id="avatar-uploader-button">
                        <img src="/media/profile/buttons/download-arrow.png" id="uploader-image" />
                        Upload avatar
                    </a>
                    <form id="uploader-form" action="/user/avatar/upload" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" />
                        <input type="submit"/>
                    </form>
                </div>
            </div>
            <div class="info">
                <span class="name"><?= $user->firstName . ' ' . $user->lastName ?></span>
                <span class="location">
                    <?= $user->getCity()->name . ' ' . $user->getRegion()->name . ' ' . $user->getCountry()->name ?>
                </span>
            </div>
        </div>
        <div id="background-photo-popup">
            <a id="background-uploader-button">Upload photo</a>
            <form id="background-uploader-form" action="/user/background/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="background-image" />
                <input type="submit"/>
            </form>
        </div>
    </section>
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
    <section class="content"></section>
</main>
<?php $this->show('profile/footer.php'); ?>
