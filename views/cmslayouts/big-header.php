<?php
use app\views\Constants;
use luya\Hook;
use luya\cms\widgets\LangSwitcher;
?>
<header class="site-header" style="background-image: url(<?=Hook::string(Constants::HOOK_HEADER_BG_IMAGE)?>)">
    <div class="site-header-languages">
	<?=LangSwitcher::widget([
	    'listElementOptions' => ['class' => 'site-header-languages__list'],
	    'elementOptions' => ['class' => 'site-header-languages__item'],
	    'linkOptions' => ['class' => 'site-header-languages__link'],
	    'linkLabel' => function($lang) {
		return mb_strtoupper (mb_substr ($lang['name'], 0, 3));
	    },
	]);?>
    </div>
    <div class="site-header-content">
	<?=$placeholders['content']?>
    </div>
    <div class="site-header-bottom">
	<?=$placeholders['bottom']?>
    </div>
</header>
