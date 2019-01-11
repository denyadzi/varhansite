<?php
/**
 * View file for block: MediaBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

use app\assets\blocks\MediaAsset;

MediaAsset::register($this);

?>
<section class="media-block">
    <div class="row">
        <div class="one-half column">
            <?php if ($scFrame = $this->extraValue('sc_frame_escaped')): ?>
                <div class="media-block__frame-wrapper">
                    <?=$scFrame?>
                </div>
            <?php endif ?>
            <?php if ($scLink = $this->extraValue('sc_url_escaped')): ?>
                <div class="media-block__more-link-wrapper">
                    <a href="<?=$scLink?>" target="_blank" class="media-block__more-link">
                        <?=Yii::t('blocks/media', 'more_music')?>
                    </a>
                </div>
            <?php endif ?>
        </div>
        <div class="one-half column">
            <?php if ($ytFrame = $this->extraValue('youtube_frame_escaped')): ?>
                <div class="media-block__frame-wrapper">
                    <?=$ytFrame?>
                </div>
            <?php endif ?>
            <?php if ($ytLink = $this->extraValue('youtube_url_escaped')): ?>
                <div class="media-block__more-link-wrapper">
                    <a href="<?=$ytLink?>" target="_blank" class="media-block__more-link">
                        <?=Yii::t('blocks/media', 'more_video')?>
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>
