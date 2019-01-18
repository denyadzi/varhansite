<?php
/**
 * View file for block: SocialLinksBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

use app\assets\blocks\SocialLinksAsset;

SocialLinksAsset::register($this);

?>
<section class="social-links-block">
    <h4 class="social-links-block__title"><?=Yii::t('blocks/social-links', 'title')?></h4>
    <div class="social-links-block__container">
        <?php foreach ($this->extraValue('escaped_links') as $link): ?>
            <a class="social-links-block__link" href="<?=$link['link']?>" target="_blank">
                <img src="<?=$link['icon']?>">
            </a>
        <?php endforeach ?>
    </div>
</section>
