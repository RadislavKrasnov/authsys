<?php $this->show('profile/header.php'); ?>
<main>
    <section class="user-info-section"
             style="background-image: url('/media/profile/background/calanques-marseille-istock-johansjolander.jpg')">
        <div class="user-info-center">
            <div class="avatar">
                <img src="https://via.placeholder.com/200" alt="#" />
            </div>
            <div class="info">
                <span class="name"><?= $user->firstName . ' ' . $user->lastName ?></span>
                <span class="location">
                    <?= $user->getCity()->name . ' ' . $user->getRegion()->name . ' ' . $user->getCountry()->name ?>
                </span>
            </div>
        </div>
    </section>
    <section class="content"></section>
</main>
<?php $this->show('profile/footer.php'); ?>
