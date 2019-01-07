<?php
/**
 * View file for block: NavigationBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
use luya\Hook;
use app\views\Constants;
use app\assets\blocks\NavigationAsset;

NavigationAsset::register($this);
?>
<nav class="navigation-block js-nav-sticky">
    <ul class="navigation-block__list js-nav-tiny-target">
	<?php foreach (Yii::$app->menu->findAll(['parent_nav_id' => 0, 'container' => 'default']) as $item): ?>
	    <li class="navigation-block__list-item">
		<a class="navigation-block__link" href="<?=$item->link?>"><?=$item->title?></a>
	    </li>
	    <?php if ($item->isHome): ?>
		<?php foreach (Hook::iterate(Constants::HOOK_NAVIGATION_INJECT_AFTER_HOME) as $href => $title): ?>
		    <li class="navigation-block__list-item">
			<a class="navigation-block__link" href="<?=$href?>"><?=$title?></a>
		    </li>
		<?php endforeach ?>
	    <?php endif ?>
	<?php endforeach ?>
    </ul>
</nav>
