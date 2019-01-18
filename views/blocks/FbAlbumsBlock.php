<?php
/**
 * View file for block: FbAlbumsBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

use app\assets\blocks\FbAlbumsAsset;

FbAlbumsAsset::register($this);

?>

<section class="fb-albums-block">
    <div class="container">
        <?php $i = 0; ?>
        <?php foreach ($this->extraValue('gallery_data') as $id => $albumData):?>
            <?php if (0 == $i % 3): ?>
                <div class="row">
            <?php endif ?>
                <div class="four columns">
                    <a href="<?=$albumData['cover_photo']['source']?>"
                       class="fb-albums-block__image"
                       style="background-image: url('<?=$albumData['cover_photo']['preview']?>')"
                       data-lightbox="<?=$id?>"
                       data-title="<?=$albumData['cover_photo']['name']?>"></a>
                    <?php foreach ($albumData['photos'] as $photoData): ?>
                        <a href="<?=$photoData['source']?>"
                           data-lightbox="<?=$id?>"
                           data-title="<?=$photoData['name']?>"></a>
                    <?php endforeach ?>
                </div>
                <?php if ($i++ && 0 == $i % 3): ?>
                </div>
                <?php endif ?>
        <?php endforeach ?>
    </div>
</section>
