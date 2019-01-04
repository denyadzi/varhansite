<?php
use app\views\Constants;
use luya\Hook;
?>
<header class="site-header" style="background-image: url(<?=Hook::string(Constants::HOOK_HEADER_BG_IMAGE)?>)">
    <div class="site-header-content">
	<?=$placeholders['content']?>
    </div>
    <div class="site-header-bottom">
	<?=$placeholders['bottom']?>
    </div>
</header>
