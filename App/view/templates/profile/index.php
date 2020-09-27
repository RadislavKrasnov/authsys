<?php $this->show('profile/header.php'); ?>
<main>
    <section class="user-info-section"
             style="background-image: url('/media/profile/background/calanques-marseille-istock-johansjolander.jpg')">
        <div class="user-info-center">
            <div class="avatar">
                <img src="https://via.placeholder.com/200" alt="#" />
            </div>
            <div class="info">
                <span class="name">John Smith</span>
                <span class="location">Marseille, Provance-Alpes-Cote D'Azure, France</span>
            </div>
        </div>
    </section>
    <section class="content"></section>
</main>
<?php $this->show('profile/footer.php'); ?>
