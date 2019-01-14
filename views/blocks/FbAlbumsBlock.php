<?php
/**
 * View file for block: FbAlbumsBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
?>

<section class="fb-albums-block">
    <div class="container">
        <div class="row">
            <?php foreach ($this->extraValue('gallery_data') as $id => $albumData):?>
                <div class="four columns">
                    <a href="<?=$albumData['cover_photo']['source']?>"
                       data-lightbox="<?=$id?>"
                       data-title="<?=$albumData['cover_photo']['name']?>"><img src="<?=$albumData['cover_photo']['picture']?>"/></a>
                    <?php foreach ($albumData['photos'] as $photoData): ?>
                        <a href="<?=$photoData['source']?>"
                           data-lightbox="<?=$id?>"
                           data-title="<?=$photoData['name']?>"></a>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
