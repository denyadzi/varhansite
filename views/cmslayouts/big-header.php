<?php
use app\views\Constants;
use luya\Hook;
?>
<header style="background-image: url(<?=Hook::string(Constants::HOOK_HEADER_BG_IMAGE)?>)">
    <div>
	<?=$placeholders['content']?>
    </div>
    <div class="placeholder-bottom">
	<?=$placeholders['bottom']?>
    </div>
</header>
