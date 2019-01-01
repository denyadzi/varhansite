<?php
use app\views\Constants;
use luya\Hook;
?>
<header style="background-image: url(<?=Hook::string(Constants::HOOK_HEADER_BG_IMAGE)?>)">
    <?=$placeholders['content']?>
</header>
