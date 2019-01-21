<?php
use app\views\Constants;
use luya\Hook;
use luya\cms\widgets\LangSwitcher;
?>
<header class="site-header site-header--big" style="background-image: url(<?=Hook::string(Constants::HOOK_HEADER_BG_IMAGE)?>)">
    <div class="site-languages--big-header">
    <!--
	<?=LangSwitcher::widget([
	    'listElementOptions' => ['class' => 'site-languages--big-header__list'],
	    'elementOptions' => ['class' => 'site-languages--big-header__item'],
	    'linkOptions' => ['class' => 'site-languages--big-header__link'],
	    'linkLabel' => function($lang) {
		return mb_strtoupper (mb_substr ($lang['name'], 0, 3));
	    },
	 ]);?>-->
        <ul class="site-languages--big-header__list">
            <?php foreach (['en', 'ru', 'by'] as $langCode): ?>
                <li class="site-languages--big-header__item">
                    <a class="site-languages--big-header__link" href="<?=$langCode == 'by' ? '/' : "/$langCode/homepage"?>"><?=mb_strtoupper ($langCode)?></a>
                </li>
        <?php endforeach ?>
        </ul>
    </div>
    <div class="site-header-content site-header-content--big">
	<?=$placeholders['content']?>
    </div>
    <div class="site-header-bottom site-header-bottom--big">
	<?=$placeholders['bottom']?>
    </div>
</header>
