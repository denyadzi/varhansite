<?php
/**
 * View file for block: StaticBackgroundBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
use app\assets\blocks\StaticBackgroundAsset;

StaticBackgroundAsset::register($this);
?>
<section class="static-background-block" style="background-image: url(<?=$this->extraValue('background_url')?>)">
</section>
