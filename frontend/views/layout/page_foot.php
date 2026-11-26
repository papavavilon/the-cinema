<?php
/* Спільний елемент оформлення сторінок. */ ?>
<footer class="site-footer">
    <div class="wrap footer-grid">
        <div>
            <a class="wordmark" href="<?= url() ?>">
                thecinema
                <span>
                    •
                </span>
            </a>
            <p>
                Big screen. Good company.
                <br>
                Your cinema in Esbjerg.
            </p>
        </div>
        <div>
            <p class="eyebrow">
                Find your next film
            </p>
            <a href="<?= url("movies") ?>">
                Films & times
            </a>
            <a href="<?= url("news") ?>">
                The Cinema Journal
            </a>
            <a href="<?= url("about") ?>">
                Our cinema
            </a>
        </div>
        <div>
            <p class="eyebrow">
                Come on over
            </p>
            <a href="https://www.google.com/maps/search/?api=1&query=<?= rawurlencode($co["Location"]) ?>" target="_blank" rel="noopener">
                <?= e($co["Location"]) ?>
            </a>
            <a href="mailto:<?= e($co["Email"]) ?>">
                <?= e($co["Email"]) ?>
            </a>
            <a href="<?= url("contact") ?>">
                Send a message ↗
            </a>
        </div>
    </div>
    <div class="wrap footer-bottom">
        <span>
            © <?= date("Y") ?> thecinema
        </span>
        <span>
            Student demo · No real payments
        </span>
        <a href="<?= url("admin/dashboard") ?>">
            Staff access
        </a>
    </div>
</footer>
<script src="<?= url("frontend/assets/js/navigation.js?v=3") ?>" defer>
</script>
<script src="<?= url("frontend/assets/js/seats.js?v=3") ?>" defer>
</script>
<script src="<?= url("frontend/assets/js/forms.js?v=3") ?>" defer>
</script>
</body>
</html>
