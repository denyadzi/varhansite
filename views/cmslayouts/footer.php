<?php
use luya\Hook;
use app\views\Constants;
?>
<footer class="site-footer">
    <div class="site-footer__content">
        <?= $placeholders['content']; ?>
    </div>
    <div class="site-footer-social">
        <?php foreach (Hook::iterate(Constants::HOOK_SOCIAL_LINKS) as $icon => $link): ?>
            <a class="site-footer-social__link" href="<?=$link?>" target="_blank">
                <img src="<?=$icon?>">
            </a>
        <?php endforeach ?>
    </div>
</footer>
